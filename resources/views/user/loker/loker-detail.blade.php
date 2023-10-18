@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="col-lg-10 offset-1 p-4 rounded bg-white min-vh-150">
            <div class="d-flex">
                <div class="col-1">
                    <img src="{{ asset('logo/' . $loker->employer->logo_perusahaan) }}" class="img-fluid">
                </div>
                <div class="col-9 px-3">
                    <h5 class="text-capitalize fw-semibold">{{ $loker->nama_pekerjaan }}</h5>
                    <h6 class="fw-semibold text-capitalize">{{ $loker->employer->nama_perusahaan }}</h6>
                    <h6 class="text-capitalize">{{ $loker->lokasi_pekerjaan }} | {{ $loker->jenis_pekerjaan }} |
                        {{ $loker->tipe_pekerjaan }} </h6>
                    <h6 class="text-capitalize">Open For Recruitment Until : {{ $loker->deadline->format('Y-m-d') }}
                    </h6>
                </div>
                <div class="col-2">
                    <div>
                        @if ($loker->status === 'Open')
                            <h6 class="text-success fw-semibold">Open For Recruitment</h6>
                        @elseif($loker->status === 'Closed')
                            <h6 class="text-danger fw-semibold">Closed For Recruitment</h6>
                        @endif
                    </div>
                    @auth('user')
                        @if (!$hasApplication)
                            @if ($user->profile && $user->resume)
                                <div class="my-4">
                                    <form action="/submit-application/{{ $loker->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-dark">Masukkan Lamaran</button>
                                    </form>
                                </div>
                            @elseif(!$user->profile || !$user->resume)
                                <div class="my-4">
                                    <h6 class="text-bg-warning text-center fw-semibold p-2">Profile Belum Lengkap</h6>
                                </div>
                            @endif
                        @else
                            <div class="my-4">
                                <h6 class="text-bg-success text-center fw-semibold rounded p-2">Telah Memasukkan Lamaran</h6>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="my-4">
                <h5 class="fw-semibold">Deskripsi Pekerjaan</h5>
                <p>{!! nl2br($loker->deskripsi_pekerjaan) !!}</p>
            </div>

            <div class="my-4">
                <h5 class="fw-semibold">Meet The Employer</h5>
                <div class="">
                    <h6 class="text-capitalize fw-semibold">{{ $loker->employer->nama_lengkap }} |
                        {{ $loker->employer->nama_perusahaan }} | {{ $loker->employer->jabatan }}</h6>
                </div>
            </div>

            @if ($loker->poster)
                <div class="my-4">
                    <h5 class="fw-semibold">Poster</h5>
                    <div class="d-flex justify-content-center my-2">
                        <img src="{{ asset('poster/' . $loker->poster) }}" class="img-fluid max-vh-100" alt="">
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
