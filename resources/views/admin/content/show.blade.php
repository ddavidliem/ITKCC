@extends('layouts.admin')

@section('content')
    <div class="container p-4">
        <div class="col-10 offset-1 p-4 bg-white min-vh-50 max-vh-100 overflow-auto">
            <div class="d-flex justify-content-between">
                <h4 class="fw-bold">
                    {{ $content->title }}
                </h4>
                <div class="d-flex justify-content-end">
                    <button type="button" class="align-self-center btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteContentModal">Delete</button>
                    <button type="button" class="align-self-center btn btn-outline-dark mx-2" data-bs-toggle="modal"
                        data-bs-target="#editContentModal">Edit</button>
                </div>
            </div>
            <div class="my-4">
                <p>{{ $content->body }}</p>
            </div>
            @if ($content->image)
                <div class="col-10 offset-1">
                    <img src="{{ asset('content/' . $content->image) }}" class=" img-fluid" alt="" srcset="">
                </div>
            @endif
        </div>
    </div>

    @include('admin.modal.edit-content')
    @include('admin.modal.delete-content')
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

        document.addEventListener('DOMContentLoaded', function() {
            const contentModal = document.getElementById('editContentModal');
            contentModal.addEventListener('change', function(event) {
                const clickedCheckbox = event.target;
                if (clickedCheckbox.classList.contains('modal-checkbox')) {
                    const modal = clickedCheckbox.closest('.modal');
                    const Input = modal.querySelectorAll('.edit-image-content');

                    if (clickedCheckbox.checked) {
                        Array.from(Input).forEach(Input => {
                            Input.disabled = true;
                            Input.value = null;
                        })
                    } else {
                        Array.from(Input).forEach(Input => {
                            Input.disabled = false;
                        })
                    }
                }

            })
        });
    </script>
@endpush
