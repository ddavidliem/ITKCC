@extends('layouts.employer')


@section('content')
    <div class="container p-4">
        <div class="d-flex">
            <div class="col-lg-3 px-2">
                <div class="bg-white rounded border-1 min-vh-25 list-group list-group-flush p-3">
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#logoModal">
                        Logo Perusahaan
                    </button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#editModal">
                        Edit Data Perusahaan
                    </button>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModal">Form Edit Data Employer</h1>
                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                    aria-label="close"></button>
                            </div>

                            <form action="">
                                @csrf
                                <div class="modal-body min-vh-100">
                                    <div class="mb-1 p-2">
                                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control" id="nama_perusahaan"
                                            value="{{ $employer->nama_perusahaan }}" name="nama_perusahaan">
                                    </div>
                                    <div class="mb-1 p-2">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat"
                                            value="{{ $employer->alamat }}" name="alamat">
                                    </div>
                                    <div class="mb-1 p-2">
                                        <label for="alamat" class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi"
                                            value="{{ $employer->provinsi }}" name="provinsi">
                                    </div>
                                    <div class="mb-1 p-2">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat"
                                            value="{{ $employer->alamat }}" name="alamat">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

                <div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="logoModal">Form Upload Foto Profile</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="/employer-update-logo" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <h2 class="text-capitalize text-center">Upload Logo</h2>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="logo" aria-describedby="logo"
                                            aria-label="Upload" name="logo" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if (!$employer->logo_perusahaan)
                    <div class="mb-4 col-lg-12 p-2 bg-warning rounded border-1">
                        <p class="fw-semibold text-center">Silahkan Menambah Logo Perusahaan</p>
                    </div>
                @endif
                <div class="bg-white rounded border-1 min-vh-25 p-4">
                    <h2 class="mb-4">Informasi Perusahaan</h2>
                    <div class="d-flex ">
                        @if ($employer->logo_perusahaan)
                            <div class="mb-1 justify-content-center">
                                <img src="{{ asset('logo/' . $employer->logo_perusahaan) }}" alt=""
                                    class="rounded" style="width:120px; height:100px;">
                            </div>
                        @endif
                        <div class="mb-1 row px-4 col-lg-8">
                            <label for="" class="col-lg-4 col-form-label fs-6">Nama Perusahaan</label>
                            <div class="col-lg-8">
                                <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                                    value="{{ $employer->nama_perusahaan }}">
                            </div>
                            <label for="" class="col-lg-4 col-form-label fs-6">Alamat</label>
                            <div class="col-lg-8">
                                <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                                    value="{{ $employer->alamat }}">
                            </div>
                            <label for="" class="col-lg-4 col-form-label fs-6">Kota</label>
                            <div class="col-lg-8">
                                <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                                    value="{{ $employer->kota }}">
                            </div>
                            <label for="" class="col-lg-4 col-form-label fs-6">Website</label>
                            <div class="col-lg-8">
                                <input type="text" readonly class="form-control-plaintext fs-6"
                                    value="{{ $employer->website }}">
                            </div>
                        </div>

                    </div>




                </div>
                <div class="bg-white rounded border-1 min-vh-10 my-4 p-4">
                    <h2 class="mb-4">Informasi Employer</h2>
                    <div class="mb-1 row px-1 col-lg-8">
                        <label for="" class="col-lg-4 col-form-label fs-6">Nama</label>
                        <div class="col-lg-8">
                            <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                                value="{{ $employer->nama_lengkap }}">
                        </div>
                        <label for="" class="col-lg-4 col-form-label fs-6">Jabatan</label>
                        <div class="col-lg-8">
                            <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                                value="{{ $employer->jabatan }}">
                        </div>
                        <label for="" class="col-lg-4 col-form-label fs-6">Nomor Telepon</label>
                        <div class="col-lg-8">
                            <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                                value="{{ $employer->nomor_telepon }}">
                        </div>
                        <label for="" class="col-lg-4 col-form-label fs-6">Email</label>
                        <div class="col-lg-8">
                            <input type="text" readonly class="form-control-plaintext fs-6"
                                value="{{ $employer->alamat_email }}">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
