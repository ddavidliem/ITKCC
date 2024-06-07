@extends('layouts.user')

@section('content')
    <div class="p-4">
        <div class="p-4 bg-white rounded min-vh-75">
            <h4 class="fw-semibold">Detail Lowongan Kerja</h4>
            <div class="my-4 d-flex">
                <div class="col-1">
                    <img src="{{ asset('logo/' . $loker->employer->logo_perusahaan) }}" alt=""
                        class="img-fluid px-1 align-self-center">
                </div>
                <div class="px-4 col-7">
                    <div class="d-flex justify-content-between">
                        <h5 class="fw-semibold">{{ $loker->nama_pekerjaan }}</h5>
                        <div>
                            <button class="btn btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#submitApplication">Masukkan Lamaran</button>
                        </div>
                    </div>
                    <ul class="list-unstyled">
                        <li class="fw-semibold text-capitalize">{{ $loker->employer->nama_perusahaan }}</li>
                        <li>{{ $loker->jenis_pekerjaan }} | {{ $loker->tipe_pekerjaan }}</li>
                        <li>{{ $loker->lokasi_pekerjaan }}</li>
                        <li>Deadline: {{ $loker->created_at->format('d-m-Y') }}</li>
                        <li>Status: {{ $loker->status }}</li>
                        <li>Total Pelamar: {{ $loker->applicants()->count() }}</li>
                    </ul>
                    <div class="my-2">
                        <h6 class="fw-semibold">Deskripsi Pekerjaan</h6>
                        <div class="my-2">
                            <p>{{ $loker->deskripsi_pekerjaan }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-4 px-2">
                    <div class="my-2">
                        <div class="my-2">
                            <img src="{{ asset('poster/' . $loker->poster) }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.modal.submit-application')
@endsection
