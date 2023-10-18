@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="p-4 bg-white rounded min-vh-100">
            <h5 class="fw-bold">Form Pendaftaran Perusahaan (Peneydia Kerja)</h5>
            <div class="my-2 p-4">
                <form action="/employer-submit-approval" method="post" class="needs-validation" enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    <div class="">
                        <h6 class="fw-semibold">Informasi Login</h6>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Username</label>
                            <input type="text" name="username"
                                class="form-control @error('username')is-invalid @enderror" required
                                value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-semibold">Informasi Perusahaan</h6>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan"
                                class="form-control @error('nama_perusahaan')is-invalid @enderror" required
                                value="{{ old('nama_perusahaan') }}">
                            @error('nama_perusahaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Alamat Perusahaan</label>
                            <input type="text" name="alamat" class="form-control" required value="{{ old('alamat') }}">
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" required
                                value="{{ old('provinsi') }}">
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Kota</label>
                            <input type="text" name="kota" class="form-control" required value="{{ old('kota') }}">
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" required
                                value="{{ old('kode_pos') }}">
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Website Perusahaan</label>
                            <input type="text" name="website" class="form-control" value="{{ old('website') }}">
                        </div>
                    </div>
                    <div class="">
                        <h6 class="fw-semibold">Informasi Employer (Hiring Team)</h6>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" required
                                value="{{ old('nama_lengkap') }}">
                        </div>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" required
                                value="{{ old('jabatan') }}">
                        </div>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                name="nomor_telepon" required value="{{ old('nomor_telepon') }}">
                            @error('nomor_telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Alamat Email</label>
                            <input type="email" class="form-control @error('alamat_email') is-invalid @enderror"
                                name="alamat_email" required value="{{ old('alamat_email') }}">
                            <div class="form-text">
                                Gunakan Email Perusahaan Yang Aktif Untuk Melakukan Verifikasi
                            </div>
                            @error('alamat_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Formulir Pendaftaran</label>
                            <input type="file" class="form-control" name="formulir" required>
                            <div class="form-text">
                                Formulir Pendaftaran Bisa Didapatkan <a href="/register-form-template"
                                    class="text-decoration-none text-dark">Download Template</a>
                            </div>
                            <div class="form-text">
                                File Dalam Bentuk PDF
                            </div>
                        </div>
                        <div class="my-3">
                            <div class="captcha">
                                <span class="">{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>
                        <div class="my-3">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                name="captcha" required>
                            @error('captcha')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="my-4 d-flex justify-content-end">
                        <button class="btn btn-outline-dark" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script type="module">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: '/refresh-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });

        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endpush
