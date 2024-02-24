@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="min-vh-75 p-4 bg-white rounded">
            <div class="d-flex justify-content-between">
                <h4 class="fw-semibold">Detail Pengguna</h4>
                <div class="d-flex">
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editUser">Edit</button>
                    <button class="btn btn-outline-danger mx-2" data-bs-toggle="modal"
                        data-bs-target="#deleteUser">Delete</button>
                </div>
            </div>
            <div class="my-4 d-flex">
                <div class="col-2 p-1">
                    <img src="{{ asset('profile/' . $user->profile) }}" class="img-fluid" alt="">
                    <div class="my-2">
                        <button class="btn btn-outline-dark px-2" data-bs-toggle="modal"
                            data-bs-target="#userResume">Resume</button>
                    </div>
                </div>
                <div class="col-3 px-4">
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
                        <label for="" class="form-label">Bergabung</label>
                        <h6 class="fw-semibold">{{ $user->created_at->toDateString() }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Verifikasi</label>
                        @if ($user->email_verification)
                            <h6 class="fw-semibold text-success">Verified</h6>
                        @endif
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Disabilitas</label>
                        @if ($user->disabilitas)
                            <h6 class="fw-semibold text-success">{{ $user->disablitas }}</h6>
                        @endif
                    </div>
                </div>
                <div class="col-4 px-2">
                    <div class="my-2">
                        <label for="" class="form-label">Tempat, Tanggal Lahir</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->tempat_lahir }}, {{ $user->tanggal_lahir }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kewarganegaraan</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->kewarganegaraan }}</h6>
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
                        <label for="" class="form-label">Alamat</label>
                        <h6 class="fw-semibold">{{ $user->alamat }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kota</label>
                        <h6 class="fw-semibold">{{ $user->kota }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kode Pos</label>
                        <h6 class="fw-semibold">{{ $user->kode_pos }}</h6>
                    </div>
                </div>
                <div class="col-2 px-1">
                    <div class="my-2">
                        <label for="" class="form-label">Program Studi</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->program_studi }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Nim</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->nim }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">IPK</label>
                        <h6 class="fw-semibold text-capitalize">{{ $user->ipk }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Pendidikan Tertinggi</label>
                        <h6 class="fw-semibold">{{ $user->pendidikan_tertinggi }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Status Perkawinan</label>
                        <h6 class="fw-semibold">{{ $user->status_perkawninan }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="min-vh-50 my-4 bg-white rounded p-4">
            <h4 class="fw-semibold">Sertifikat</h4>
            <div class="min-vh-25 max-vh-50 overflow-auto">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Sertifikat</th>
                            <th>Organisasi</th>
                            <th>Tanggal Terbit</th>
                            <th>Tanggal Berakhir</th>
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
                                <td class="d-flex">
                                    <button class="btn btn-outline-dark" id="editSertifikatBtn" data-bs-toggle="modal"
                                        data-bs-target="#editSertifikat"
                                        data-url="{{ Route('admin.user.sertifikat.update', ['user' => $user->id, 'id' => $item->id]) }}"
                                        data-id="{{ Route('admin.user.sertifikat.detail', ['user' => $user->id, 'id' => $item->id]) }}">Edit</button>
                                    <button class="btn btn-outline-danger mx-2" id="deleteSertifikatBtn"
                                        data-bs-toggle="modal" data-bs-target="#deleteSertifikat"
                                        data-url="{{ Route('admin.user.sertifikat.delete', ['user' => $user->id, 'id' => $item->id]) }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded min-vh-50 max-vh-50 overflow-auto p-4 my-4">
            <div class="d-flex justify-content-between">
                <h4 class="fw-semibold">Pendidikan</h4>
            </div>

            <div class="min-vh-25 max-vh-75 overflow-auto my-4">
                <table class="table table-hover p-4">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Nama Sekolah</th>
                            <th>Bidang Studi</th>
                            <th>Tingkat Pendidikan</th>
                            <th>Tahun Lulus</th>
                            <th>Alamat Sekolah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->pendidikan as $item)
                            <tr>
                                <td>{{ $item->nama_sekolah }}</td>
                                <td>{{ $item->bidang_studi }}</td>
                                <td>{{ $item->tingkat_pendidikan }}</td>
                                <td>{{ $item->tahun_lulus }}</td>
                                <td>{{ $item->alamat_sekolah }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-outline-dark" id="editPendidikanBtn"
                                        data-url="{{ Route('admin.user.pendidikan.update', ['id' => $item->id, 'user' => $item->user_id]) }}"
                                        data-id="{{ Route('admin.user.pendidikan.detail', ['id' => $item->id, 'user' => $item->user_id]) }}"
                                        data-bs-target="#editPendidikan" data-bs-toggle="modal">Edit</button>
                                    <button class="btn btn-outline-danger mx-2" id="deletePendidikanBtn"
                                        data-url="{{ Route('admin.user.pendidikan.delete', ['id' => $item->id, 'user' => $item->user_id]) }}"
                                        data-bs-toggle="modal" data-bs-target="#deletePendidikan">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="min-vh-50 my-4 bg-white rounded p-4">
            <h4 class="fw-semibold">Pengalaman Kerja</h4>
            <div class="min-vh-25 max-vh-50 overflow-auto">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Pengalaman</th>
                            <th>Jenis Pekerjaan</th>
                            <th>Organisasi / Perusahaan</th>
                            <th>Lokasi Pekerjaan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->pengalaman as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->jenis_pekerjaan }}</td>
                                <td>{{ $item->organisasi }}</td>
                                <td>{{ $item->lokasi_pekerjaan }}</td>
                                <td>{{ $item->tanggal_mulai }}</td>
                                <td>{{ $item->tanggal_selesai }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-outline-dark" id="editPengalamanBtn" data-bs-toggle="modal"
                                        data-bs-target="#editPengalaman"
                                        data-url="{{ Route('admin.user.pengalaman.edit', ['id' => $item->id, 'user' => $user->id]) }}"
                                        data-id="{{ Route('admin.user.pengalaman.detail', ['id' => $item->id, 'user' => $user->id]) }}">Edit</button>
                                    <button class="btn btn-outline-danger mx-2" id="deletePengalamanBtn"
                                        data-bs-toggle="modal" data-bs-target="#deletePengalaman"
                                        data-url="{{ Route('admin.user.pengalaman.delete', ['id' => $item->id, 'user' => $user->id]) }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="min-vh-50 my-4 bg-white rounded p-4">
            <h4 class="fw-semibold">Application Lowongan Kerja</h4>
            <div class="min-vh-25 max-vh-50 overflow-auto">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th class="fw-semibold">Nama Lowongan Kerja</th>
                            <th class="fw-semibold">Nama Perusahaan</th>
                            <th class="fw-semibold">Jenis Lowongan Kerja</th>
                            <th class="fw-semibold">Lokasi</th>
                            <th class="fw-semibold">Tanggal Lamaran</th>
                            <th class="fw-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->applications as $item)
                            <tr>
                                <td>{{ $item->loker->nama_pekerjaan }}</td>
                                <td>{{ $item->loker->employer->nama_perusahaan }}</td>
                                <td>{{ $item->loker->jenis_pekerjaan }}</td>
                                <td>{{ $item->loker->lokasi_pekerjaan }}</td>
                                <td>{{ $item->loker->created_at->toDateString() }}</td>
                                <td>{{ $item->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="min-vh-50 my-4 bg-white rounded p-4">
            <div class="d-flex justify-content-between mb-4">
                <h4 class="fw-semibold">Appointment Konseling Karir</h4>
                <div>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newAppointment">Buat
                        Appointment Konseling</button>
                </div>
            </div>
            <div class="min-vh-25 max-vh-50 overflow-auto">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th class="fw-semibold">Topik</th>
                            <th class="fw-semibold">Jenis Konseling</th>
                            <th class="fw-semibold">Tanggal dan Jam Konseling</th>
                            <th class="fw-semibold">Tempat Konseling</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->appointment as $item)
                            <tr>
                                <td>{{ $item->topik }}</td>
                                <td>{{ $item->jenis_konseling }}</td>
                                <td>{{ $item->date_time }}</td>
                                <td>{{ $item->tempat_konseling }}</td>
                                <td>{{ $item->status }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-outline-dark" id="editAppointmentBtn" data-bs-toggle="modal"
                                        data-bs-target="#editAppointment"
                                        data-id="{{ Route('admin.appointment.detail', ['id' => $item->id]) }}"
                                        data-url="{{ Route('admin.appointment.update', ['id' => $item->id]) }}">Edit</button>
                                    <button class="btn btn-outline-danger mx-2" id="deleteAppointmentBtn"
                                        data-bs-toggle="modal" data-bs-target="#deleteAppointment"
                                        data-url="{{ Route('admin.appointment.delete', ['id' => $item->id]) }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.user.modal.resume')
    @include('admin.user.modal.edit-user')
    @include('admin.user.modal.delete-user')
    @include('admin.user.modal.new-appointment')
    @include('admin.user.modal.edit-appointment')
    @include('admin.user.modal.delete-appointment')
    @include('admin.user.modal.delete-sertifikat')
    @include('admin.user.modal.edit-sertifikat')
    @include('admin.user.modal.edit-pengalaman')
    @include('admin.user.modal.delete-pengalaman')
    @include('admin.user.modal.new-pendidikan')
    @include('admin.user.modal.edit-pendidikan')
    @include('admin.user.modal.delete-pendidikan')
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            window.scrollTo(0, 0);
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

            const deleteAppointmentBtn = document.querySelectorAll('#deleteAppointmentBtn');
            const deleteAppointmentForm = document.getElementById('deleteAppointmentForm');
            Array.from(deleteAppointmentBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteAppointmentForm.setAttribute('action', btn.getAttribute(
                        'data-url'));
                });
            });

            const editAppointmentBtn = document.querySelectorAll('#editAppointmentBtn');
            const editAppointmentForm = document.getElementById('editAppointmentForm');
            Array.from(editAppointmentBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    editAppointmentForm.setAttribute('action', btn.getAttribute(
                        'data-url'));
                    $.ajax({
                        type: "GET",
                        url: this.getAttribute('data-id'),
                        success: function(response) {
                            $('#topik option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    response.topik)
                            });
                            $('#jenis_konseling option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    response.jenis_konseling);
                            });
                            $('#tempat_konseling option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    response.tempat_konseling);
                            });
                            $('#google_meet').val(response.google_meet);
                            var appointmentTime = new Date(response.date_time);
                            $('#tanggal_konseling').val(appointmentTime.toISOString()
                                .split('T')[0]);
                            $('#jam_konseling option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    appointmentTime.toTimeString()
                                    .substring(0, 8));
                            });

                        }
                    });
                });
            });

            const newAppointment = document.querySelectorAll('.appointment');
            newAppointment.forEach(function(modal) {
                modal.addEventListener('change', function() {
                    const select = event.target;

                    if (select.classList.contains('tempat_konseling')) {
                        const input = modal.querySelector('#google_meet');

                        if (select.value === 'Online') {
                            input.setAttribute('required', true);
                            input.disabled = false;
                        } else {
                            input.removeAttribute('required');
                            input.disabled = true;
                        }
                    }
                });
            });

            const editSertifikatBtn = document.querySelectorAll('#editSertifikatBtn');
            const edtiSertifikatForm = document.getElementById('editSertifikatForm');
            Array.from(editSertifikatBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    edtiSertifikatForm.setAttribute('action', btn.getAttribute('data-url'));
                    $.ajax({
                        type: "GET",
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
                    deleteSertifikatForm.setAttribute('action', btn.getAttribute('data-url'));
                })
            });

            const editPengalamanBtn = document.querySelectorAll('#editPengalamanBtn');
            const editPengalamanForm = document.getElementById('editPengalamanForm');
            Array.from(editPengalamanBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    editPengalamanForm.setAttribute('action', btn.getAttribute('data-url'));
                    $.ajax({
                        type: "GET",
                        url: this.getAttribute('data-id'),
                        success: function(response) {
                            console.log(response);
                            $('#title_pengalaman').val(response.title);
                            $('#organisasi_pengalaman').val(response.organisasi);
                            $('#lokasi_pengalaman').val(response.lokasi_pekerjaan);
                            $('#deskripsi_pengalaman').val(response.deskripsi);
                            $('#jenis_pekerjaan option').each(function() {
                                $(this.prop('selected', $(this).val() ===
                                    response.jenis_pekerjaan));
                            });
                            var tanggal_mulai = response.tanggal_mulai.split(' ');
                            $('#bulan_mulai option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_mulai[0]);
                            });
                            $('#tahun_mulai option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_mulai[1]);
                            });
                            var tanggal_selesai = response.tanggal_selesai.split(' ');
                            $('#bulan_selesai option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_selesai[0]);
                            });
                            $('#tahun_selesai option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    tanggal_selesai[1]);
                            });

                        }
                    });
                });
            });

            const deletePengalamanBtn = document.querySelectorAll('#deletePengalamanBtn');
            const deletePengalamanForm = document.getElementById('deletePengalamanForm');
            Array.from(deletePengalamanBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    deletePengalamanForm.setAttribute('action', btn.getAttribute('data-url'));
                });
            });

            const editPendidikanBtn = document.querySelectorAll('#editPendidikanBtn');
            const editPendidikanForm = document.getElementById('editPendidikanForm');
            Array.from(editPendidikanBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    editPendidikanForm.setAttribute('action', btn.getAttribute('data-url'));

                    $.ajax({
                        type: "GET",
                        url: this.getAttribute('data-id'),
                        success: function(response) {
                            $('#nama_sekolah').val(response.nama_sekolah);
                            $('#bidang_studi').val(response.bidang_studi);
                            $('#alamat_sekolah').val(response.alamat_sekolah);
                            $('#keterangan').val(response.keterangan);
                            $('#tahun_lulus').val(response.tahun_lulus);
                            $('#tingkat_pendidikan option').each(function() {
                                $(this).prop('selected', $(this).val() ===
                                    response.tingkat_pendidikan);
                            });
                        }
                    });
                });
            });

            const deletePendidikanBtn = document.querySelectorAll('#deletePendidikanBtn');
            const deletePendidikanForm = document.getElementById('deletePendidikanForm');
            Array.from(deletePendidikanBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    deletePendidikanForm.setAttribute('action', btn.getAttribute('data-url'));
                });
            })

        });
    </script>
@endpush
