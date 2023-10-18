@extends('layouts.admin')

@section('content')
    <div class="container p-4">
        <div class="p-4">
            <div class="p-4 bg-white min-vh-50">
                <div class="d-flex justify-content-between">
                    <h4 class="fw-semibold">Carousel Detail</h4>
                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-dark mx-2" data-bs-toggle="modal"
                            data-bs-target="#editCarouselModal">Edit</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteCarouselModal">Delete</button>
                    </div>
                </div>
                <div class="my-4">
                    <h6 class="fw-semibold">{{ $carousel->title }}</h6>
                    <div class="my-2">
                        <ul class="list-unstyled">
                            @if ($carousel->status === true)
                                <li class="text-success">Active</li>
                            @else
                                <li class="text-danger">Not Active</li>
                            @endif
                            <li>
                                {{ $carousel->created_at->format('Y-m-d H:i:s') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="my-4">
                    <img src="{{ asset('content/' . $carousel->image) }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
        @include('admin.modal.edit-carousel')
        @include('admin.modal.delete-carousel')
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
