@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="p-4 bg-white rounded min-vh-50">
            <form action="{{ Route('auth.reset.password') }}" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="my-2">
                    <label for="" class="fw-semibold form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="my-2">
                    <label for="" class="fw-semibold form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                    <div class="form-text">
                        Mohon Memasukkan Password Yang Sama Dengan Benar
                    </div>
                </div>
                <input type="hidden" name="token" value="{{ $token }}" readonly>
                <div class="my-3 d-flex justify-content-end">
                    <button class="btn btn-outline-dark">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
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
