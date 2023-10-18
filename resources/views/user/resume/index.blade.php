@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="d-flex">
            <div class="col-9 px-2">
                <div class="p-4 bg-white rounded min-vh-75">
                    <div class="d-flex justify-content-between">
                        <h4 class="fw-bold">User Resume</h4>
                        <button class="btn btn-outline-dark fw-semibold align-self-center" data-bs-toggle="modal"
                            data-bs-target="#uploadResumeModal">
                            Update Resume
                        </button>
                    </div>
                    <div>
                        @if ($user->resume)
                            <div class="d-flex justify-content-center">
                                <iframe src="{{ asset('resume/' . $user->resume) }}" frameborder="0" class="my-4"
                                    width="100%" height="700px"></iframe>
                            </div>
                        @else
                            @include('component.empty', ['message' => 'Resume Tidak Ditemukan'])
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="p-4 bg-white rounded min-vh-25">
                    <img src="{{ asset('component/coaching-clinic.png') }}" class="img-fluid" alt="">
                    <h6 class="fw-bold text-center my-2">Jangan Pikirin Sendiri <br> Mulai Konseling Aja Dulu</h6>
                    <div class="my-4 d-flex justify-content-center">
                        <a href="/konsultasi" class="btn btn-outline-dark">Make Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.modal.resume')
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
