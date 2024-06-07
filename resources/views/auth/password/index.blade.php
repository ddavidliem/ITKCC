@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="p-4 bg-white rounded min-vh-50">
            <h4 class="fw-semibold">Reset Password Form</h4>
            <div class="my-4">
                <form action="{{ Route('auth.reset.password.link') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" id=""
                            required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="user">User (Pencari Kerja/Mahasiswa)</option>
                            <option value="employer">Employer (Perusahaan)</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="fw-semibold form-label">Email</label>
                        <input type="email" class="form-control @error('alamat_email') is-invalid @enderror"
                            name="alamat_email" required>
                        <div class="form-text">
                            Masukkan Alamat Email yang terdaftar dan terverifikasi.
                        </div>
                        @error('alamat_email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
                        <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror"
                            placeholder="Enter Captcha" name="captcha" required>
                        <div class="form-text">
                            Masukkan Captcha
                        </div>
                        @error('captcha')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">Submit</button>
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
            const forms = document.querySelectorAll('.needs-validation')
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
