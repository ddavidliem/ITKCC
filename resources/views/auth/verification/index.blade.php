@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="p-4 bg-white rounded min-vh-50">
            <h5 class="fw-semibold">Verifikasi Email</h5>
            <div class="my-3">
                <form action="/send/email-verification" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('patch')
                    <div class="my-4">
                        <div class="my-2">
                            <label for="" class="fw-semibold">Kategori Pengguna</label>
                            <select name="kategori" class="form-select" id="" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="user">User (Pencari kerja)</option>
                                <option value="employer">Employer (Perusahaan)</option>
                            </select>
                        </div>
                        <div class="my-2">
                            <label for="" class="fw-semibold form-label">Alamat Email</label>
                            <input type="email" class="form-control" name="alamat_email" required>
                            <div class="form-text">
                                Email Verifikasi Akan Dikirim Melalui Email Yang Terdaftar, Link Verifikasi Memiliki Batas
                                Waktu 10 Menit.
                            </div>
                        </div>
                    </div>
                    <div class="my-2 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">Kirim Link Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
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
