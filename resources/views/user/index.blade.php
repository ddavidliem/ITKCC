@extends('layouts.user')

@section('content')
    <div class="p-4">
        <div class="bg-white rounded min-vh-75 p-4 mb-4">
            <div class="d-flex justify-content-between mb-4">
                <h4 class="fw-semibold">Profile</h4>
                <div class="d-flex">
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editProfile">
                        Edit Profile
                    </button>
                    <button class="btn btn-outline-dark mx-2" data-bs-toggle="modal" data-bs-target="#updateProfileImg">
                        Profile Image
                    </button>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal"
                        data-bs-target="#uploadResume">Resume</button>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-2 p-2">
                    <img src="{{ asset('profile/' . $user->profile) }}" class="img-fluid" alt="">
                </div>
                <div class="col-4 mx-4">
                    <div class="my-2">
                        <label for="" class="form-label">Nama Lengkap</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->nama_lengkap }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Alamat Email</label>
                        <h6 class="fw-semibold">{{ $user->alamat_email }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Nomor Telepon</label>
                        <h6 class="fw-semibold">{{ $user->nomor_telepon }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Verifikasi Email</label>
                        <h6 class="fw-semibold text-success">
                            @if ($user->email_verification)
                                Verified
                            @endif
                        </h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Nim</label>
                        <h6 class="fw-semibold">
                            {{ $user->nim }}
                        </h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Program Studi</label>
                        <h6 class="fw-semibold">
                            {{ $user->program_studi }}
                        </h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Pendidikan Tertinggi</label>
                        <h6 class="fw-semibold">
                            {{ $user->pendidikan_tertinggi }}
                        </h6>
                    </div>
                </div>
                <div class="col-4 mx-4">
                    <div class="my-2">
                        <label for="" class="form-label">Tempat & Tanggal Lahir</label>
                        <h6 class="fw-semibold">{{ $user->tempat_lahir }}, {{ $user->tanggal_lahir }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kewarganegaraan</label>
                        <h6 class="fw-semibold">{{ $user->kewarganegaraan }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Jenis Kelamin</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->jenis_kelamin }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Agama</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->agama }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Status Perkawinan</label>
                        <h6 class="fw-semibold">{{ $user->status_perkawinan }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kota</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->kota }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Alamat</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->alamat }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Disabilitas</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->disabilitas }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded min-vh-50 max-vh-50 overflow-auto p-4 my-4">
            <div class="d-flex justify-content-between">
                <h5 class="fw-semibold">Sertifikat</h5>
                <div>
                    <button class="btn btn-outline-dark" data-bs-target="#newSertifikat" data-bs-toggle="modal">Tambah
                        Sertifikat</button>
                </div>
            </div>
            <div class="min-vh-25 max-vh-75 overflow-auto my-4">
                <table class="table table-hover p-4">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Sertifikat</th>
                            <th>Organisasi</th>
                            <th>Tanggal Terbit</th>
                            <th>Tanggal Berakhir</th>
                            <th>ID Sertifikat</th>
                            <th>URL Sertifikat</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->sertifikat as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->organisasi }}</td>
                                <td>{{ $item->tanggal_terbit }}</td>
                                <td>{{ $item->tanggal_berakhir }}</td>
                                <td>{{ $item->id_sertifikat }}</td>
                                <td>{{ $item->url_sertifikat }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-outline-dark" id="editSertifikatBtn"
                                        data-url="{{ Route('user.sertifikat.update', ['id' => $item->id]) }}"
                                        data-id="{{ Route('user.sertifikat.detail', ['id' => $item->id]) }}"
                                        data-bs-target="#editSertifikat" data-bs-toggle="modal">Edit</button>
                                    <button class="btn btn-outline-danger mx-2" id="deleteSertifikatBtn"
                                        data-url="{{ Route('user.sertifikat.delete', ['id' => $item->id]) }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteSertifikat">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="bg-white rounded min-vh-50 max-vh-75 overflow-auto p-4 my-4">
            <div class="d-flex justify-content-between">
                <h5 class="fw-semibold">Pengalaman</h5>
                <div>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newPengalaman">Tambah
                        Pengalaman</button>
                </div>
            </div>
            <div class="my-4 min-vh-25 max-vh-50 overflow-auto">
                <table class="table table-hover p-4">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Pengalaman Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->pengalaman as $item)
                            <tr>
                                <td class="p-4 d-flex justify-content-between">
                                    <div class="col-10">
                                        <h5 class="fw-semibold">{{ $item->title }}</h5>
                                        <ul class="list-unstyled">
                                            <li><span class="fw-semibold text-capitalize">{{ $item->organisasi }}</span> |
                                                {{ $item->jenis_pekerjaan }}</li>
                                            <li class="text-capitalize fw-semibold">{{ $item->lokasi_pekerjaan }}</li>
                                            <li class="text-capitalize fw-semibold">{{ $item->tanggal_mulai }}
                                                @if ($item->tanggal_selesai)
                                                    - {{ $item->tanggal_selesai }}
                                                @endif
                                            </li>
                                            @if (!empty($item->deskripsi))
                                                <li><a href="" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#description-{{ $item->id }}"aria-expanded="false"
                                                        class="text-decoration-none text-muted">Deskripsi
                                                        Pekerjaan</a></li>
                                                <li>
                                                    <div class="collapse" id="description-{{ $item->id }}">
                                                        <p>{!! nl2br($item->deskripsi) !!}</p>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-outline-dark" data-bs-toggle="modal"
                                            id="editPengalamanBtn" data-bs-target="#editPengalaman"
                                            data-id="{{ Route('user.pengalaman.detail', ['id' => $item->id]) }}"
                                            data-url="{{ Route('user.pengalaman.update', ['id' => $item->id]) }}">Edit</button>
                                        <button class="btn btn-outline-danger mx-2" data-bs-toggle="modal"
                                            data-bs-target="#deletePengalaman"
                                            data-url="{{ Route('user.pengalaman.delete', ['id' => $item->id]) }}">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded min-vh-50 max-vh-100 overflow-auto p-4 my-4">
            <div class="d-flex justify-content-between">
                <h5 class="fw-semibold">Appointment Konseling Karir</h5>
                <div>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newAppointment">Buat
                        Appointment Konseling Karir</button>
                </div>
            </div>
            <div class="my-4 min-vh-50 max-vh-75 overflow-auto">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Appointment Konseling Karir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->appointment as $item)
                            <tr>
                                <td class="p-4 d-flex justify-content-between">
                                    <div class="col-10">
                                        <h5 class="fw-semibold">{{ $item->topik }}</h5>
                                        <ul class="list-unstyled">
                                            <li>Tanggal dan Waktu: {{ $item->date_time }}</li>
                                            <li>{{ $item->jenis_konseling }} |
                                                {{ $item->tempat_konseling }}</li>
                                            <li class="text-capitalize">Status: {{ $item->status }}</li>
                                            @if (!empty($item->feedback))
                                                <li><a href="" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#description-{{ $item->id }}"aria-expanded="false"
                                                        class="text-decoration-none text-muted">Feedback Konseling</a></li>
                                                <li>
                                                    <div class="collapse" id="description-{{ $item->id }}">
                                                        <p>{!! nl2br($item->feedback) !!}</p>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="col-2">
                                        @if ($item->status === 'reschedule')
                                            <button class="btn btn-outline-dark" id="updateAppointmentBtn"
                                                data-bs-toggle="modal" data-bs-target="#updateAppointment"
                                                data-url="{{ Route('user.appointment.update', ['id' => $item->id]) }}">Reschedule</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded min-vh-50 max-vh-100 overflow-auto p-4 my-4">
            <h5 class="fw-semibold">Application Lowongan Kerja</h5>
            <div class="my-4 min-vh-50 max-vh-75 overflow-auto">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Application Lowongan Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->applications as $item)
                            <tr>
                                <td class="p-4 d-flex justify-content-between">
                                    <div class="col-10">
                                        <h5 class="fw-semibold">{{ $item->loker->nama_pekerjaan }}</h5>
                                        <ul class="list-unstyled">
                                            <li class="fw-semibold">{{ $item->loker->employer->nama_perusahaan }}</li>
                                            <li>{{ $item->loker->jenis_pekerjaan }} | {{ $item->loker->tipe_pekerjaan }}
                                            </li>
                                            <li>{{ $item->loker->lokasi }}</li>
                                            <li class="text-capitalize">{{ $item->status }}</li>
                                            @if (!empty($item->feedback))
                                                <li><a href="" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#description-{{ $item->id }}"aria-expanded="false"
                                                        class="text-decoration-none text-muted">Feedback Application</a>
                                                </li>
                                                <li>
                                                    <div class="collapse" id="description-{{ $item->id }}">
                                                        <p>{!! nl2br($item->feedback) !!}</p>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    @include('user.modal.edit-profile')
    @include('user.modal.new-sertifikat')
    @include('user.modal.edit-sertifikat')
    @include('user.modal.delete-sertifikat')
    @include('user.modal.new-pengalaman')
    @include('user.modal.edit-pengalaman')
    @include('user.modal.delete-pengalaman')
    @include('user.modal.new-appointment')
    @include('user.modal.edit-appointment')
    @include('user.modal.profile-image')
    @include('user.modal.resume')
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            window.scrollTo(0, 0);
            const pengalamanModal = document.querySelectorAll('.form-pengalaman');
            pengalamanModal.forEach(function(form) {
                form.addEventListener('change', function(event) {
                    const clickedCheckbox = event.target;
                    if (clickedCheckbox.classList.contains('modal-checkbox')) {
                        const modal = clickedCheckbox.closest('.modal');
                        const selectInput = modal.querySelectorAll('.end-date');

                        if (clickedCheckbox.checked) {
                            Array.from(selectInput).forEach(selectInput => {
                                selectInput.removeAttribute('required');
                                selectInput.disabled = true;
                                selectInput.value = selectInput.querySelector(
                                        'option:first-child')
                                    .value;
                            })
                        } else {
                            Array.from(selectInput).forEach(selectInput => {
                                selectInput.setAttribute('required', 'required');
                                selectInput.disabled = false;
                            })
                        }
                    }
                });
            });

            const editSertifikatBtn = document.querySelectorAll('#editSertifikatBtn');
            const editSertifikatForm = document.getElementById('editSertifikatForm');
            Array.from(editSertifikatBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    editSertifikatForm.setAttribute('action', btn.getAttribute('data-url'));

                    $.ajax({
                        type: "Get",
                        url: this.getAttribute('data-id'),
                        success: function(response) {
                            $('#title').val(response.title);
                            $('#organisasi').val(response.organisasi);
                            $('#id_sertifikat').val(response.id_sertifikat);
                            $('#url_sertifikat').val(response.url_sertifikat);
                            var tanggal_terbit = response.tanggal_terbit.split(' ');
                            $('#bulan_terbit option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_terbit[0]);
                            });
                            $('#tahun_terbit option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_terbit[1]);
                            });
                            var tanggal_berakhir = response.tanggal_berakhir.split(' ');
                            $('#bulan_berakhir option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_berakhir[0]);
                            });
                            $('#tahun_berakhir option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_berakhir[1]);
                            });
                        }
                    });
                });
            });

            const deleteSertifikatBtn = document.querySelectorAll('#deleteSertifikatBtn');
            const deleteSertifikatForm = document.getElementById('deleteSertifikatForm');
            Array.from(deleteSertifikatBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteSertifikatForm.setAttribute('action', btn.getAttribute(
                        'data-url'));
                });
            });

            const editPengalamanBtn = document.querySelectorAll('#editPengalamanBtn');
            const editPengalamanForm = document.getElementById('editPengalamanForm');
            Array.from(editPengalamanBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    editPengalamanForm.setAttribute('action', btn.getAttribute('data-url'));
                    $.ajax({
                        type: "Get",
                        url: this.getAttribute('data-id'),
                        success: function(response) {
                            $('#title_pengalaman').val(response.title);
                            $('#lokasi_pengalaman').val(response.lokasi_pekerjaan);
                            $('#deskripsi').val(response.deskripsi);
                            $('#jenis_pekerjaan option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    jenis_pekerjaan);
                            });
                            $('#organisasi_pengalaman').val(response.organisasi);
                            var tanggal_mulai = response.tanggal_mulai.split(' ');
                            $('#bulan_mulai_pengalaman option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_mulai[0]);
                            });
                            $('#tahun_mulai_pengalaman option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_mulai[1]);
                            });
                            var tanggal_selesai = response.tanggal_selesai.split(' ');
                            $('#bulan_selesai_pengalaman option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_selesai[0]);
                            });
                            $('#tahun_selesai_pengalaman option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_selesai[1]);
                            });
                        }
                    });
                });
            });

            const deletePengalamanBtn = document.querySelectorAll('#deletePengalamanBtn');
            const deletePengalamanForm = document.getElementById('deletePengalamanForm');
            Array.from(
                deletePengalamanBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    deletePengalamanForm.setAttribute('action', btn.getAttribute('data-url'));
                });
            });

            const updateAppointmentBtn = document.querySelectorAll('#editAppointmentBtn');
            const updateAppointmentForm = document.getElementById('updateAppointmentForm');
            Array.from(
                updateAppointmentBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    updateAppointmentForm.setAttribute('action', btn.getAttribute('data-url'));
                });
            });

            (() => {
                'use strict';
                const modals = document.querySelectorAll('.modal');
                Array.from(modals).forEach(modal => {
                    const forms = modal.querySelectorAll('.form-validate');
                    Array.from(forms).forEach(form => {
                        form.addEventListener('submit', event => {
                            if (form.closest('.modal') === modal && !form
                                .checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                });
            })();
        });
    </script>
@endpush
