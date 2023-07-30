@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="col-lg-10 offset-1 p-4 rounded bg-white overflow-auto min-vh-50 max-vh-100">
            <div class="d-flex">
                <div class="">
                    <img src="{{ asset('logo/' . $loker->employer->logo_perusahaan) }}" alt=""
                        style="width: 100px; height:100px">
                </div>
                <div class="px-3">
                    <h2 class="text-capitalize">{{ $loker->nama_pekerjaan }}</h2>
                    <small class="fs-6 fw-semibold text-capitalize">{{ $loker->employer->nama_perusahaan }}</small>
                </div>

            </div>
            <div class="my-4">
                <ul class="list-unstyled">
                    <li class="fs">{{ $loker->jenis_pekerjaan }}</li>
                    <li>{{ $loker->lokasi_pekerjaan }}</li>
                    <li>{{ $loker->created_at->diffForHumans() }}</li>
                    <li>Jumlah Pelamar : {{ $application }}</li>
                </ul>
            </div>

            @auth
                <div class="my-4">
                    <form action="/submit-application/{{ $loker->id }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </form>
                </div>
            @endauth

            <div class="my-4">
                <h5 class="fw-semibold">Deskripsi Pekerjaan</h5>
                <p>{!! nl2br($loker->deskripsi_pekerjaan) !!}</p>
            </div>

            <div class="my-4">
                <h5 class="fw-semibold">Meet The Employer</h5>
                <div class="">
                    <h4 class="text-capitalize">{{ $employer->nama_lengkap }}</h4>
                    <small class="text-capitalize">{{ $employer->jabatan }}</small>
                    <br>
                    <small class="text-capitalize fw-semibold">{{ $employer->nama_perusahaan }}</small>
                </div>
            </div>

            @if ($loker->poster)
                <div class="">
                    <h5 class="fw-semibold">Poster</h5>
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('poster/' . $loker->poster) }}" style="width:400px; height:400px"
                            alt="">

                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
@endpush
