@extends('layouts.employer')


@section('content')
    <div class="container p-4">
        <div class="d-flex">
            <div class="col-9">
                <div class="p-4 bg-white rounded min-vh-75">
                    <div>
                        <h5 class="fw-bold">Informasi Perusahaan</h5>
                        <div class="d-flex my-4">
                            <div class="col-2 p-2">
                                @if ($employer->logo_perusahaan)
                                    <img src="{{ asset('logo/' . $employer->logo_perusahaan) }}" class="img-fluid"
                                        alt="">
                                @endif
                            </div>
                            <div class="col-10 mx-4">
                                <div class="d-flex">
                                    <div class="col-6 p-2">
                                        <div class="my-3">
                                            <label for="" class=" form-label">Nama Perusahaan</label>
                                            <h6 class="fw-semibold text-capitalize">{{ $employer->nama_perusahaan }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class=" form-label">Website</label>
                                            <h6 class="fw-semibold">{{ $employer->website }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class="form-label">Bidang Perusahaan</label>
                                            <h6 class="fw-semibold">{{ $employer->bidang_perusahaan }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class="form-label">Tahun Berdiri</label>
                                            <h6 class="fw-semibold">{{ $employer->tahun_berdiri }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class="form-label">Kantor Pusat</label>
                                            <h6 class="fw-semibold">{{ $employer->kantor_pusat }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class="form-label">Jumlah Lowongan Kerja</label>
                                            <h6 class="fw-semibold">{{ $loker->loker_count }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-6 p-2">
                                        <div class="my-3">
                                            <label for="" class=" form-label">Kota</label>
                                            <h6 class="fw-semibold text-capitalize">{{ $employer->kota }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class=" form-label">Provinsi</label>
                                            <h6 class="fw-semibold text-capitalize">{{ $employer->provinsi }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class=" form-label">Alamat</label>
                                            <h6 class="fw-semibold text-capitalize">{{ $employer->alamat }}</h6>
                                        </div>
                                        <div class="my-3">
                                            <label for="" class=" form-label">Kode Pos</label>
                                            <h6 class="fw-semibold text-capitalize">{{ $employer->kode_pos }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 mx-3">
                <div class="p-4 bg-white rounded min-vh-15 list-group list-group-flush">
                    <a href="" type="button" class="list-group-item fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#editCompany">Edit Profile Perusahaan</a>
                    <a href="" type="button" class="list-group-item fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#editEmployer">Edit Profile Employer</a>
                    <a href="" type="button" class="list-group-item fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#uploadLogo">Upload Logo Perusahaan @if (!$employer->logo_perusahaan)
                            <span class="badge text-bg-warning">!</span>
                        @endif </a>
                </div>
                <div class="my-3 p-4 bg-white min-vh-15">
                    <h6 class="fw-bold">Informasi Pribadi</h6>
                    <div class="my-3">
                        <h5 class="fw-semibold">{{ $employer->nama_lengkap }}</h5>
                        <h6 class="text-dark text-capitalized">{{ $employer->jabatan }}</h6>
                        <h6 class="text-dark">{{ $employer->nomor_telepon }}</h6>
                        <h6 class="text-dark">{{ $employer->alamat_email }}</h6>
                    </div>
                </div>
            </div>
        </div>

        @include('employer.modal.employer-logo')
        @include('employer.modal.employer-edit')
        @include('employer.modal.employer-edit-company')
    @endsection

    @push('script')
        <script type="module">
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
