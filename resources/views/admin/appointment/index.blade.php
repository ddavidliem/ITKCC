@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="min-vh-75 bg-white rounded p-4">
            <h4 class="fw-bold">Appointment Konseling Pusat Karir ITK</h4>
            <div class="d-flex my-4">
                <div class="col-5">
                    <ul class="list-unstyled list-group list-group-flush">
                        <li class="list-group-item d-flex my-1">
                            <h6 class="col-10 fw-semibold">Jumlah Total Appointment</h6>
                            <h6 class="col-2">{{ $appointment['total'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Appointment Di Setujui</h6>
                            <h6 class="col-2">{{ $appointment['approved'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Appointment Selesai</h6>
                            <h6 class="col-2">{{ $appointment['done'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Appointment Dalam Proses</h6>
                            <h6 class="col-2">{{ $appointment['pending'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Total Appointment Minggu Ini</h6>
                            <h6 class="col-2">{{ $appointment['week'] }}</h6>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-flex p-4 my-4">
                <div class="col-7">
                    <h6 class="fw-semibold">Total Appointment 6 Bulan Terakhir</h6>
                    <div>
                        <canvas id="appointment-total-chart" class="img-fluid"></canvas>
                    </div>
                </div>
                <div class="col-4 mx-4">
                    <h6 class="fw-semibold">Presentase Status Appointment Saat Ini</h6>
                    <div>
                        <canvas id="appointment-status-chart" class="img-fluid"></canvas>
                    </div>
                </div>
            </div>
            <div class="d-flex p-4 my-4">
                <div class="col-6">
                    <div class="d-flex align-items-center mb-2">
                        <h6 class="fw-semibold col-6">Topik Konseling Karir</h6>
                        <div class="col-6 d-flex justify-content-end ">
                            <button class="fw-semibold btn btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#addTopic">Tambah
                                Topik</button>
                        </div>
                    </div>
                    <div class="max-vh-50 min-vh-50 overflow-auto">
                        <table class="table table-hover table-borderless">
                            <thead class="table-light">
                                <tr class="position-sticky top-0">
                                    <th class="fw-semibold">Daftar Topik Appointment Konseling Karir</th>
                                    <th class="fw-semibold text-center">Jumlah</th>
                                    <th class="fw-semibold text-center">Status</th>
                                    <th class="fw-semibold text-center">Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topics as $item)
                                    <tr>
                                        <td>{{ $item->topik }}</td>
                                        <td class="text-center">{{ $item->appointments_count }}</td>
                                        <td class="text-center">{{ $item->status == 'enable' ? 'Aktif' : 'Tidak Aktif' }}
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <button class="btn btn-outline-dark edit-btn"
                                                data-url="{{ Route('admin.appointment.topik.update', ['id' => $item->id]) }}"
                                                data-bs-target="#editTopic" data-bs-toggle="modal"
                                                data-content="{{ $item->topik }}"
                                                data-content-status="{{ $item->status }}">Edit</button>
                                            <button class="mx-2 btn btn-outline-danger delete-btn"
                                                data-url="{{ Route('admin.appointment.topik.delete', ['id' => $item->id]) }}"
                                                data-bs-target="#deleteTopic" data-bs-toggle="modal"
                                                data-content="{{ $item->topik }}">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-4 offset-1">
                    <h6 class="fw-semibold">Presentase Topik Appointment Saat Ini</h6>
                    <div>
                        <canvas id="appointment-topic-chart" class="img-fluid"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-4 bg-white rounded p-4 min-vh-100 max-vh-100">
            <h4 class="fw-semibold my-4">Jadwal Konseling Karir Pusat Karir ITK</h4>
            <div id="calendar" class="max-vh-75 overflow-auto"></div>
        </div>

        <div class="my-4 p-4 min-vh-100 max-vh-100 d-flex">
            <div class="col-4">
                <div class="p-4 bg-white rounded min-vh-100 max-vh-100 overflow-auto">
                    <div class="d-flex">
                        <input type="text" class="form-control" id="search" placeholder="Search Appointment">
                    </div>
                    <div class="my-4 max-vh-75 overflow-auto">
                        <table class="table table-hover table-borderless" role="tablist" id="tablist">
                            <thead class="table-light">
                                <tr class="position-sticky top-0">
                                    <th class="fw-semibold">Daftar Appointment Konseling Karir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointment['all'] as $item)
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0)" type="button" role="tab"
                                                class="text-decoration-none text-dark d-flex p-2"
                                                aria-controls="{{ $item->id }}"
                                                data-bs-target="#tab-{{ $item->id }}" data-bs-toggle="tab">
                                                <div class="col-10">
                                                    <h6 class="fw-semibold my-2 text-capitalize">
                                                        {{ $item->user->nama_lengkap }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li class="text-capitalize">{{ $item->topik }}</li>
                                                        <li class="text-capitalize">{{ $item->jenis_konseling }}</li>
                                                        <li class="text-capitalize">{{ $item->user->nomor_telepon }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="text-capitalize fw-semibold">{{ $item->status }}</h6>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>

                    </div>
                </div>
            </div>

            <div class="col-8 mx-2">
                <div class="p-4 bg-white rounded min-vh-100 max-vh-100 overflow-auto">
                    <div class="tab-content" id="tab-content">
                        @foreach ($appointment['all'] as $item)
                            <div id="tab-{{ $item->id }}" class="p-2 tab-pane" role="tabpanel">
                                <div class="bg-white p-44 min-vh-10 mb-3">
                                    <div class="d-flex mb-4">
                                        <h3 class="fw-bold col-10">Detail Janji Temu Konseling</h3>
                                        <div class="col-2 d-flex justify-content-end">
                                            <button class="btn btn-outline-dark response-appointment-btn mx-2"
                                                data-bs-toggle="modal" data-bs-target="#responseAppointment"
                                                data-url="{{ Route('admin.appointment.response', ['id' => $item->id]) }}">Status</button>
                                            <button class="btn btn-outline-danger delete-appointment-btn"
                                                data-bs-toggle="modal" data-bs-target="#deleteAppointment"
                                                data-url="{{ Route('admin.appointment.delete', ['id' => $item->id]) }}">Delete</button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <div class="mb-4">
                                                <h6>Topik Konseling : <span class="fw-semibold">{{ $item->topik }}</span>
                                                </h6>
                                                <h6>Tanggal Konseling : <span
                                                        class="fw-semibold">{{ $item->date_time }}</span></h6>
                                                @if ($item->status === 'approved')
                                                    <h6>Approved : <span
                                                            class="fw-semibold">{{ $item->updated_at }}</span>
                                                    </h6>
                                                @elseif($item->status === 'not approved')
                                                    <h6>Not Approved : <span
                                                            class="fw-semibold">{{ $item->updated_at }}</span></h6>
                                                @elseif($item->status === 'pending')
                                                    <h6>Status : <span
                                                            class="fw-semibold text-capitalize">{{ $item->status }}</span>
                                                    </h6>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Informasi Peserta Konseling</h5>
                                        <div class="d-flex">
                                            <div class="col-5 mx-2">
                                                <div class="my-1">
                                                    <label for="" class="form-label">Nama Peserta</label>
                                                    <h6 class="fw-semibold text-capitalize">
                                                        {{ $item->user->nama_lengkap }}
                                                    </h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Alamat Email</label>
                                                    <h6 class="fw-semibold">{{ $item->user->alamat_email }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Nomor Telepon</label>
                                                    <h6 class="fw-semibold">{{ $item->user->nomor_telepon }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Jenis Kelamin</label>
                                                    <h6 class="fw-semibold text-capitalize">
                                                        {{ $item->user->jenis_kelamin }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-5 mx-2">
                                                <div class="my-1">
                                                    <label for="" class="form-label">Alamat</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->user->alamat }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Program Studi</label>
                                                    <h6 class="fw-semibold">{{ $item->user->program_studi }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Tanggal Lahir</label>
                                                    <h6 class="fw-semibold">{{ $item->user->tanggal_lahir }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.appointment.modal.edit-topic')
    @include('admin.appointment.modal.new-topic')
    @include('admin.appointment.modal.delete-topic')
    @include('admin.appointment.modal.response-appointment')
    @include('admin.appointment.modal.delete-appointment')
@endsection

@push('script')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function() {
            const editBtn = document.querySelectorAll('.edit-btn');
            const editForm = document.getElementById('editTopicForm');
            const editTarget = document.getElementById('edit-topik');
            const editStatus = document.getElementById('edit-status-topik')
            Array.from(editBtn).forEach(editBtn => {
                editBtn.addEventListener('click', function() {
                    editForm.setAttribute('action', editBtn.getAttribute('data-url'));
                    editTarget.value = editBtn.getAttribute('data-content');
                    editStatus.value = editBtn.getAttribute('data-content-status');
                });
            });

            const deleteBtn = document.querySelectorAll('.delete-btn');
            const deleteForm = document.getElementById('deleteTopicForm');
            const deleteTarget = document.getElementById('delete-target');
            Array.from(deleteBtn).forEach(deleteBtn => {
                deleteBtn.addEventListener('click', function() {
                    deleteForm.setAttribute('action', deleteBtn.getAttribute('data-url'));
                    deleteTarget.innerHTML = deleteBtn.getAttribute('data-content');
                });
            });

            const appointmentStatus = @json($appointment);
            const appointmentTotal = @json($appointmentData);
            const appointmentTopic = @json($appointmentTopicsChart);
            const appointmentStatusDataConfig = {
                labels: ['Accepted', 'On Process'],
                datasets: [{
                    data: [appointmentStatus['approved'], appointmentStatus['pending']],
                }]
            };

            const appointmentTotalDataConfig = {
                labels: appointmentTotal.labels,
                datasets: [{
                    label: 'Total Appointment 6 Bulan Terakhir',
                    data: appointmentTotal.data,
                }],
            };

            const appointmentTopicDataConfig = {
                labels: appointmentTopic.label,
                datasets: [{
                    data: appointmentTopic.data,
                }],
            };

            const appointmentTotalChart = new Chart(document.getElementById('appointment-total-chart'), {
                type: 'line',
                data: appointmentTotalDataConfig,
            });

            const appointmentStatusChart = new Chart(document.getElementById('appointment-status-chart'), {
                type: 'doughnut',
                data: appointmentStatusDataConfig,
            });

            const appointmentTopicChart = new Chart(document.getElementById('appointment-topic-chart'), {
                type: 'doughnut',
                data: appointmentTopicDataConfig,
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const event = @json($appointment['all']);
            const eventArray = event.map(event => ({
                title: event.user.nama_lengkap,
                start: event.date_time,
            }));
            const calendar = new Calendar(document.getElementById('calendar'), {
                plugins: [timegrid, list, fullCalendarStyle],
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next,today',
                    center: '',
                    right: 'timeGridWeek,timeGridDay,listWeek',
                },
                themeSystem: 'bootstrap5',
                businessHours: {
                    startTime: '08:00',
                    endTime: '16:00',
                },
                weekends: false,
                slotMinTime: '08:00:00',
                slotMaxTime: '16:00:00',
                events: eventArray,
            });
            calendar.render();

        });
        document.addEventListener('DOMContentLoaded', function() {
            const dltBtnAppointments = document.querySelectorAll('.delete-appointment-btn');
            const dltAppointmentForm = document.getElementById('deleteAppointmentForm');
            Array.from(dltBtnAppointments).forEach(dltBtnAppointment => {
                dltBtnAppointment.addEventListener('click', function() {
                    dltAppointmentForm.setAttribute('action', dltBtnAppointment.getAttribute(
                        'data-url'));
                });
            });

            const responseBtn = document.querySelectorAll('.response-appointment-btn');
            const responseForm = document.getElementById('responseAppointmentForm');
            Array.from(responseBtn).forEach(response => {
                response.addEventListener('click', function() {
                    responseForm.setAttribute('action', response.getAttribute(
                        'data-url'));
                });
            });
        });
        $(document).ready(function() {
            $('#search').on('input', function() {
                searchTable();
            });

            function searchTable() {
                const searchQuery = $('#search').val().toLowerCase();
                const $rows = $('#tablist tbody tr');
                $rows.show();
                $rows.each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.indexOf(searchQuery) === -1) {
                        $(this).hide();
                    }
                });
            }

        });
    </script>
@endpush
