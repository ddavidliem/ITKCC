@extends('layouts.employer')

@section('content')
    <div class="p-4">
        <div class="p-4 bg-white rounded min-vh-75 mb-4">
            <div class="d-flex justify-content-between">
                <h4 class="fw-semibold">Profile Perusahaan</h4>
                <div class="d-flex">
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editEmployer">Edit
                        Employer</button>
                    <button class="mx-3 btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editCompany">Edit
                        Company</button>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editLogo">Logo
                        Perusahaan @if (!$employer->logo_perusahaan)
                            <span class="badge text-bg-dark">!</span>
                        @endif </button>
                </div>
            </div>
            <div class="d-flex my-4">
                <div class="col-2 p-2">
                    <img src="{{ asset('logo/' . $employer->logo_perusahaan) }}" class="img-fluid" alt="">
                </div>
                <div class="col-3 mx-4">
                    <div class="my-2">
                        <label for="" class="form-label">Nama Perusahaan</label>
                        <h6 class="fw-semibold text-capitalize">{{ $employer->nama_perusahaan }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Bidang Perusahaan</label>
                        <h6 class="fw-semibold text-capitalize">{{ $employer->bidang_perusahaan }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Tahun Berdiri</label>
                        <h6 class="fw-semibold text-capitalize">{{ $employer->tahun_berdiri }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kantor Pusat</label>
                        <h6 class="fw-semibold text-capitalize">{{ $employer->kantor_pusat }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Website</label>
                        <h6 class="fw-semibold">{{ $employer->website }}</h6>
                    </div>
                </div>
                <div class="col-4">
                    <div class="my-2">
                        <label for="" class="form-label">Kantor Pusat</label>
                        <h6 class="fw-semibold text-capitalize">{{ $employer->kantor_pusat }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Alamat</label>
                        <h6 class="fw-semibold text-capitalize">{{ $employer->alamat }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kota</label>
                        <h6 class="fw-semibold">{{ $employer->kota }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Provinsi</label>
                        <h6 class="fw-semibold">{{ $employer->provinsi }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kode Pos</label>
                        <h6 class="fw-semibold">{{ $employer->kode_pos }}</h6>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Verifikasi Email</label>
                        @if ($employer->email_verification)
                            <h6 class="fw-semibold text-success">verified</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="my-2">
                <div class="col-8 offset-2 p-4">
                    <h5 class="fw-semibold">Detail Employer</h5>
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="my-2">
                                <label for="" class="form-label">Nama Lengkap</label>
                                <h6 class="fw-semibold text-capitalize">{{ $employer->nama_lengkap }}</h6>
                            </div>
                            <div class="my-2">
                                <label for="" class="form-label">Jabatan</label>
                                <h6 class="fw-semibold text-capitalize">{{ $employer->jabatan }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="my-2">
                                <label for="" class="form-label">Alamat Email</label>
                                <h6 class="fw-semibold">{{ $employer->alamat_email }}</h6>
                            </div>
                            <div class="my-2">
                                <label for="" class="form-label">Nomor Telepon</label>
                                <h6 class="fw-semibold text-capitalize">{{ $employer->nomor_telepon }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 bg-white rounded min-vh-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="fw-semibold">Lowongan Kerja Perusahaan</h5>
                <div class="d-flex col-8 justify-content-end">
                    <div class="col-5">
                        <input type="text" role="search" id="search" class="form-control flex-grow-1"
                            placeholder="Search Lowongan Pekerjaan">
                    </div>
                    <div class="mx-4">
                        <button class="btn btn-outline-dark flex-fill" data-bs-toggle="modal"
                            data-bs-target="#newLoker">Tambah
                            Lowongan
                            Kerja</button>
                    </div>
                </div>
            </div>
            <div class="my-4 min-vh-50 max-vh-75 overflow-auto">
                <table class="table table-hover" id="loker-table">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <td class="fw-semibold">Lowongan Kerja Perusahaan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employer->loker->where('status', '!=', 'Suspended') as $item)
                            <tr>
                                <td class="p-4 d-flex justify-content-between">
                                    <div class="col-10">
                                        <h5 class="fw-semibold">{{ $item->nama_pekerjaan }}</h5>
                                        <ul class="list-unstyled">
                                            <li>Total Pelamar: {{ $item->applicants_count }}</li>
                                            <li>{{ $item->tipe_pekerjaan }} | {{ $item->jenis_pekerjaan }}</li>
                                            <li>{{ $item->lokasi_pekerjaan }}</li>
                                            <li>Status: {{ $item->status }}</li>
                                            <li>Deadline: {{ $item->deadline->format('d-m-Y') }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end">
                                        <div>
                                            <a href="{{ Route('employer.loker.detail', ['id' => $item->id]) }}"
                                                class="btn btn-outline-dark  text-decoration-none">Detail</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('employer.modal.new-loker')
    @include('employer.modal.logo')
    @include('employer.modal.edit-company')
    @include('employer.modal.edit-employer')
@endsection

@push('script')
    <script type="module">
        $(document).ready(function() {
            $('#search').on('input', function() {
                searchTable();
            });

            function searchTable() {
                const searchQuery = $('#search').val().toLowerCase();
                const $rows = $('#loker-table tbody tr');
                $rows.show();
                $rows.each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.indexOf(searchQuery) === -1) {
                        $(this).hide();
                    }
                });
            }
        });

        (() => {
            'use strict';
            const modals = document.querySelectorAll('.modal');
            Array.from(modals).forEach(modal => {
                const forms = modal.querySelectorAll('.form-validate');
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (form.closest('.modal') === modal && !form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            });
        })();
    </script>
@endpush
