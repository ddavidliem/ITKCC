@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="col-8 offset-2 p-4 bg-white min-vh-50 ">
            <h4 class="fw-bold">Appointment Detail</h4>
            <div class="my-4 p-2 d-flex justify-content-between">
                <div>
                    <h6 class="fw-semibold">{{ $appointment->topik }}</h6>
                    <ul class="list-unstyled my-2">
                        <li class="text-capitalize fw-semibold">{{ $appointment->jenis_konseling }}</li>
                        <li class="text-capitalize">{{ $appointment->tempat_konseling }}</li>
                        <li class="text-capitalize">Jadwal Konseling {{ $appointment->date_time }}</li>
                    </ul>
                    <ul class="list-unstyled">
                        <li class="">Submitted At {{ $appointment->created_at }}</li>
                    </ul>
                </div>
                <div class="d-flex">
                    <h6 class="align-self-center">{{ $appointment->status }}</h6>
                </div>
            </div>
            <div class="my-3 px-4 d-flex justify-content-end">
                <button type="button" data-bs-toggle="modal" data-bs-target="#rescheduleModal"
                    class="btn btn-outline-dark fs-5">Reschedule</button>
            </div>
        </div>
    </div>

    @include('user.modal.reschedule')
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
