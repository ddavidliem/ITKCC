@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-4 p-4">
            <div class="min-vh-25 p-4 bg-white rounded">
                <h1 class="text-center fw-bold">User Login</h1>
                <div class="py-3">
                    <form action="/login-user" method="POST" class="form-validation needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <div class="mb-3 row">
                                <label for="username" class="form-label fw-semibold">Username/Email</label>
                                <div class="col-12">
                                    <input class="form-control" type="text" name="username" placeholder="username"
                                        required autofocus>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="fw-semibold">Password</label>
                                <input class="form-control" type="password" name="password" placeholder="password" required>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit"
                                class="btn btn-light btn-outline-dark col-6 offset-3 my-2 fw-semibold">Masuk</button>
                            <a href="/forgot-password"
                                class="btn btn-light btn-outline-dark my-2 col-6 offset-3 fw-semibold">Lupa
                                Password</a>
                            <a href="/email-verification"
                                class="btn btn-light btn-outline-dark my-2 col-6 offset-3 fw-semibold">Verifikasi Email</a>
                            <a href="{{ route('auth.google', ['type' => 'user']) }}"
                                class="btn btn-light btn-outline-dark my-2 col-6 offset-3 fw-semibold">Google Sign In</a>
                        </div>
                    </form>
                </div>
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
