@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="p-4 bg-white rounded min-vh-50">
            <h4 class="fw-semibold">Detail Application</h4>
            <div class="my-4 d-flex">
                <div class="col-1">
                    <img src="{{ asset('logo/' . $application->loker->employer->logo_perusahaan) }}" class="img-fluid"
                        alt="">
                </div>
                <div class="col-5 mx-4">
                    <h5 class="fw-semibold text-capitalize">{{ $application->loker->nama_pekerjaan }}</h5>
                    <h6 class="fw-semibold text-capitalize">{{ $application->loker->employer->nama_perusahaan }}</h6>
                    <div class="my-2">
                        <h6>{{ $application->loker->lokasi_pekerjaan }} | {{ $application->loker->jenis_pekerjaan }} |
                            {{ $application->loker->tipe_pekerjaan }}
                        </h6>
                        <h6 class="fw-semibold text-capitalize">Status Lamaran : <span
                                class="text-success fw-semibold">{{ $application->status }}</span></h6>
                    </div>
                    <div class="my-2">
                        <label for="">Deadline</label>
                        <h6 class="fw-semibold">{{ $application->loker->deadline->format('Y-m-d') }}</h6>
                    </div>
                </div>
                <div class="col-6">
                    <h5 class="fw-semibold">Informasi Pelamar</h5>
                    <div class="my-1">
                        <label for="">Nama Pelamar</label>
                        <h6 class="fw-semibold">{{ $application->user->nama_lengkap }}</h6>
                    </div>
                    @if ($application->user->nim)
                        <div class="my-1">
                            <label for="">NIM ITK</label>
                            <h6 class="fw-semibold">{{ $application->user->nim }}</h6>
                        </div>
                    @endif
                    <div class="my-1">
                        <label for="">Email</label>
                        <h6 class="fw-semibold">{{ $application->user->alamat_email }}</h6>
                    </div>
                    <div class="my-1">
                        <label for="">Nomor Telepon</label>
                        <h6 class="fw-semibold">{{ $application->user->nomor_telepon }}</h6>
                    </div>
                    <div class="my-1">
                        <label for="">Tanggal Masuk Lamaran</label>
                        <h6 class="fw-semibold">{{ $application->created_at->format('Y-m-d') }}</h6>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <ul class="list-unstyled">
                    @if (!empty($application->feedback))
                        <li><a href="" type="button" data-bs-toggle="collapse"
                                data-bs-target="#description-{{ $application->id }}"aria-expanded="false"
                                class="text-decoration-none fw-semibold text-dark">Feedback</a></li>
                        <li>
                            <div class="collapse" id="description-{{ $application->id }}">
                                <p>{!! nl2br($application->feedback) !!}</p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
