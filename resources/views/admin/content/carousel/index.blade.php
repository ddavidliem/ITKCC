@extends('layouts.admin')

@section('content')
    <div class="container p-4">
        <div class="px-4">
            <div class="p-4 bg-white min-vh-50 max-vh-100 overflow-auto">
                <div class="d-flex justify-content-between">
                    <h4 class="fw-bold">Daftar Konten Carousel</h4>
                    <div>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#newCarouselForm">
                            New Carousel
                        </button>
                    </div>
                </div>
                <div class="my-4 list-group list-group-flush">
                    @if ($carousel->isEmpty())
                        @include('component.empty', ['message' => 'Carousel Belum Ditambahkan'])
                    @else
                        @foreach ($carousel as $item)
                            <a href="/contents/carousel/{{ $item->id }}"
                                class="list-group-item p-2 text-decoration-none text-dark">
                                <h6 class="fw-semibold">{{ $item->title }}</h6>
                                <div class="my-2">
                                    <ul class=" list-unstyled">
                                        @if ($item->status === true)
                                            <li class="text-success">Active</li>
                                        @else
                                            <li class="text-danger">Not Active</li>
                                        @endif
                                        <li>
                                            {{ $item->created_at->format('Y-m-d H:i:s') }}
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>

                @include('admin.modal.new-carousel')
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
