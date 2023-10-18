@extends('layouts.admin')

@section('content')
    <div class="container p-4">
        <div class="col-8 offset-2 p-4 bg-white min-vh-50">
            <h5 class="text-center fw-bold">Konten Baru</h5>
            <div class="my-4 px-4">
                <form action="/contents/new" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="my-4">
                        <label for="title_content" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" name="title_content" required>
                    </div>
                    <div class="my-4">
                        <label for="body_content" class="form-label fw-semibold">Body</label>
                        <textarea class="form-control" name="body_content"></textarea>
                    </div>
                    <div class="my-4">
                        <label for="img_content" class="form-label fw-semibold">Gambar Konten</label>
                        <input type="file" class="form-control" name="img_content">
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark px-4">Submit</button>
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
