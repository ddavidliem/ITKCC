@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="p-4 rounded min-vh-50">
            <form action="/reset-password" method="post" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" value="{{ $token }}" class="hidden form-control" readonly>
                <div class="my-2">
                    <label for="" class="fw-semibold form-label">Password Baru</label>
                    <input type="password" name="" class="form-control" required>
                </div>
                <div class="my-2">
                    <label for="" class="fw-semibold form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" required>
                </div>
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
