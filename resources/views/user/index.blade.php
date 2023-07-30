@extends('layouts.app')

@section('content')
    <div class="p-4">
        <div class="min-vh-25 col-10 offset-1 bg-white rounded p-4 mb-4">
            <div class="mb-4">
                <h1>Hi, {{ $user->nama_lengkap }}</h1>
            </div>

            @if (empty($user->resume && $user->profile))
                <div class="mb-4 accordion accordion-flush shadow">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button bg-warning rounded collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                <span class="fs-6 text-black">Yuk Lengkapi Profil Kamu Dulu</span>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse " aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body bg-warning rounded">
                                <ul class=" list-unstyled text-bold">
                                    @if (empty($user->resume))
                                        <li>Upload Resume</li>
                                    @endif
                                    @if (empty($user->profile))
                                        <li>Upload Foto Profile</li>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-evenly mb-4">
                <div class="col-lg-5 shadow p-4 ">
                    <h3>Appointment</h3>
                    <span class="fs-4">{{ $appointment }}</span>
                </div>
                <div class="col-lg-5 shadow p-4 ">
                    <h3>Application</h3>
                    <span class="fs-4">{{ $application }}</span>
                </div>
            </div>

        </div>
        <div class="p-4 col-lg-10 offset-1 rounded bg-white min-vh-50 mb-4">
            <h2>Lowongan Kerja Terbaru</h2>
            <div class="d-flex justify-content-evenly my-4">
                @if ($loker->isEmpty())
                    @include('component.empty')
                @else
                    @foreach ($loker as $item)
                        <a href="/loker/{{ $item->id }}"
                            class="rounded shadow col-lg-3 p-3 text-decoration-none text-black d-flex">
                            <div class="col-lg-4">
                                <img src="{{ asset('logo/' . $item->employer->logo_perusahaan) }}" alt=""
                                    style="width: 80px; height:60px">
                            </div>
                            <div class="col-lg-8 px-4">
                                <div class="">
                                    <small class="fs-6 fw-semibold">{{ $item->nama_pekerjaan }}</small>
                                </div>
                                <div>
                                    <small class="text-capitalize fw-semibold">
                                        {{ $item->employer->nama_perusahaan }}
                                    </small>
                                    <ul class="list-unstyled">
                                        <li>{{ $item->jenis_pekerjaan }}</li>
                                        <li>{{ $item->lokasi_pekerjaan }}</li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif

            </div>
            <div class="row">
                <h6 class="text-center "><a href="/loker" class="text-decoration-none text-black">Lihat Semuanya</a></h6>
            </div>
        </div>
    </div>
@endsection
