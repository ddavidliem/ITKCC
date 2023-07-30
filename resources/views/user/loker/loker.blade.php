@extends('layouts.app')


@section('content')
    <div class="p-4">
        <div class="d-flex justify-content-between">
            <div class="p-2 col-lg-2">
                <div class="min-vh-25 bg-white list-group list-group-flush p-4 rounded border-1">
                    <a href="" class="fw-semibold list-group-item text-decoration-none text-black">Profile</a>
                    <a href="" class="fw-semibold list-group-item text-decoration-none text-black">Resume</a>
                    <a href="" class="fw-semibold list-group-item text-decoration-none text-black">Application</a>
                </div>
            </div>
            <div class="p-2 col-lg-7">
                <div class="min-vh-100 bg-white overflow-auto list-group list-group-flush p-4 rounded border-1">
                    @if ($loker->isEmpty())
                        @include('component.empty')
                    @else
                        @foreach ($loker as $item)
                            <a href="/loker/{{ $item->id }}" class="list-group-item p-2 d-flex">
                                <img src="{{ asset('logo/' . $item->employer->logo_perusahaan) }}" alt=""
                                    class="img-logo">
                                <div class="mx-3">

                                    <div>
                                        <span class="fs-4 text-capitalize">{{ $item->nama_pekerjaan }}</span>
                                    </div>
                                    <div>
                                        <span
                                            class="fs-6 text-capitalize fw-semibold">{{ $item->employer->nama_perusahaan }}</span>
                                        <br>
                                        <small class="text-capitalize">{{ $item->lokasi_pekerjaan }}</small>
                                        <br>
                                        <small
                                            class="text-capitalize
                                        ">{{ $item->jenis_pekerjaan }}</small>
                                        <br>
                                        <small>{{ $item->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif

                </div>
            </div>

            <div class="p-2 col-lg-3">
                <div class="bg-white min-vh-25 overflow-auto p-3 rounded border-1">
                    <small class="fs-5 fw-semibold ">Job Seeker Guidance</small>
                    <br>
                    <small>Tim Coaching Clinic ITK menyediakan layanan konsultasi untuk kamu yang pingin membuat resume
                        maupun persiapan wawancara</small>
                    <div class="my-4 d-flex justify-content-center">
                        <a href="/appointment-form" class="fs-5 btn btn-primary">Buat Jadwal Konsultasi</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
