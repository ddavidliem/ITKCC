@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="p-4 d-flex">
            <div class="col-lg-8">
                <div class="p-4 min-vh-100 max-vh-100 overflow-auto bg-white rounded border-1">
                    <h3>Application</h3>
                    @if ($application->isEmpty())
                        @include('component.empty')
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($application as $item)
                                <a href="" class="list-group-item p-4 d-flex">
                                    <div>
                                        <img src="{{ asset('logo/' . $item->loker->employer->logo_perusahaan) }}"
                                            alt="" style="width: 120px">
                                    </div>
                                    <div class="px-3">
                                        <div>
                                            <h4>{{ $item->loker->nama_pekerjaan }}</h4>
                                        </div>
                                        <div>
                                            <small
                                                class="fs-5 fw-semibold text-capitalize">{{ $item->loker->employer->nama_perusahaan }}</small>
                                            <br>
                                            <ul class="list-unstyled">
                                                <li class="text-capitalize">{{ $item->loker->lokasi_pekerjaan }}</li>
                                                <li class="text-capitalize">{{ $item->loker->jenis_pekerjaan }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ms-auto align-self-center">
                                        <h6 class="text-capitalize ">{{ $item->status }}</h6>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 px-2">
                <div class="p-4 min-vh-15 bg-white rounded border-1">
                    <div>
                        <small class="fs-6">Buat kami yang butuh :</small>
                        <ul class=" list-unstyled">
                            <li class="fw-semibold">Konseling Karir</li>
                            <li class="fw-semibold">Persiapan Wawancara Kerja</li>
                            <li class="fw-semibold">Cara membuat CV</li>
                        </ul>
                        <small class="fs-6">Kamu bisa coba konsultasi dengan Tim Pusat Karir ITK</small>
                    </div>
                    <div class="my-4 d-flex justify-content-center">
                        <a href="" class="btn btn-primary fs-5">Make Appointment</a>
                    </div>

                </div>
            </div>


        </div>
    </div>
@endsection
