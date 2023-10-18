@extends('layouts.employer')

@section('content')
    <div class="p-4 container">
        <div class="d-flex justify-content-between">
            <div class="col-lg-9 px-2">
                <div class="p-4 bg-white rounded border-1 min-vh-75 max-vh-100 overflow-auto">
                    <div class="d-flex justify-content-between">
                        <h4 class="fw-bold">Employer Dashboard</h4>
                        <div class="d-flex">
                            <button class="btn btn-outline-dark" data-bs-target="#addLokerModal"
                                @if (!$employer->logo_perusahaan) disabled @endif data-bs-toggle="modal">New
                                Loker</button>
                            @if (!$employer->logo_perusahaan)
                                <div class="form-text mx-2 fw-semibold text-bg-warning p-2 rounded">
                                    Lengkapi Profile Perusahaan
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="my-4 list-group list-group-flush">
                        @if ($loker->isEmpty())
                            @include('component.empty', [
                                'message' => 'Tidak Ditemukan Lowongan Pekerjaan',
                            ])
                        @else
                            @foreach ($loker as $item)
                                <a href="/Employer/Loker/{{ $item->id }}"
                                    class="list-group-item p-1 d-flex text-decoration-none text-dark">
                                    <div class="d-flex w-100">
                                        <div class="col-1">
                                            <img src="{{ asset('logo/' . $item->employer->logo_perusahaan) }}"
                                                class="img-fluid" alt="">
                                        </div>
                                        <div class="col-8 mx-4">
                                            <h5 class="fw-semibold text-capitalize">{{ $item->nama_pekerjaan }}</h5>
                                            <ul class="list-unstyled">
                                                <li class="text-capitalize">{{ $item->lokasi_pekerjaan }} |
                                                    {{ $item->jenis_pekerjaan }} | {{ $item->tipe_pekerjaan }}</li>
                                                <li>{{ $item->deadline->format('Y-m-d') }}</li>
                                                <li>Jumlah Pelamar: <span
                                                        class="fw-semibold">{{ $item->applicants_count }}</span></li>
                                            </ul>
                                        </div>
                                        <div class="col-2 d-flex">
                                            <h6 class="fw-bold">Status</h6>
                                            @if ($item->status == 'Open')
                                                <h5 class="text-success fw-semibold align-self-center">Open</h5>
                                            @elseif($item->status == 'Closed')
                                                <h5 class="text-danger fw-semibold align-self-center">Closed</h5>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-2 bg-white rounded min-vh-10 list-group list-group-flush">
                    <a href="/Employer/Dashboard" class="list-group-item fw-semibold">Dashboard</a>
                    <a href="/Employer/Profile" class="list-group-item fw-semibold">Profile</a>
                </div>
            </div>
        </div>
    </div>
    @include('employer.modal.loker-new-form')
@endsection

@push('script')
    <script type="module">
        (() => {
            'use strict';
            const modals = document.querySelectorAll('.modal');
            Array.from(modals).forEach(modal => {
                const forms = modal.querySelectorAll('.form-validate');
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (form.closest('.modal') === modal && !form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            });
        })();
    </script>
@endpush
