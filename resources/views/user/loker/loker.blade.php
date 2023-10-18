@extends('layouts.user')


@section('content')
    <div class="container p-4">
        <div class="d-flex">
            <div class="col-9">
                <div class="p-4 bg-white rounded min-vh-150">
                    <h4 class="fw-bold">Lowongan Kerja</h4>
                    <div class="my-3">
                        @if ($loker->isEmpty())
                            @include('component.empty', ['message' => 'Belum Ada Lowongan Kerja'])
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($loker as $item)
                                    <a href="/loker/{{ $item->id }}" class="list-group-item p-2 d-flex">
                                        <div class="col-lg-1 d-flex">
                                            <img src="{{ asset('logo/' . $item->employer->logo_perusahaan) }}"
                                                alt="" class="img-fluid px-1 align-self-center">
                                        </div>
                                        <div class="col-lg-11 px-4">
                                            <h6 class="fw-semibold text-capitalize">{{ $item->nama_pekerjaan }}</h6>
                                            <ul class="list-unstyled">
                                                <li class="text-capitalize">{{ $item->employer->nama_perusahaan }}</li>
                                                <li class="text-capitalize">{{ $item->lokasi_pekerjaan }} |
                                                    {{ $item->jenis_pekerjaan }} | {{ $item->tipe_pekerjaan }}</li>
                                                @if ($item->status === 'Open')
                                                    <li class="text-capitalize text-success">Open For Recruitment</li>
                                                @elseif($item->status === 'Closed')
                                                    <li class="text-capitalize text-danger">Closed For Recruitment</li>
                                                @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mx-3 col-3">
                <div class="p-4 bg-white rounded min-vh-25">
                    <div>
                        <img src="{{ asset('component/coaching-clinic.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="my-3">
                        <h6 class="fw-semibold text-center">
                            Persiapkan Karir Kamu Bersama <br> Tim Pusat Karir ITK
                        </h6>
                    </div>
                    <div class=" d-flex justify-content-center">
                        <a href="/konsultasi" class="btn btn-outline-dark">Make Appointment</a>
                    </div>
                </div>
                <div class="my-3">
                    <div class="p-4 bg-white rounded min-vh-25">
                        <h6 class="fw-semibold">Pencarian Lowongan Kerja</h6>
                        <div class="my-4">
                            <form action="/loker/result" method="post" role="search" class="">
                                @csrf
                                <div class="my-1">
                                    <input class="form-control me-2" name="searchQuery" placeholder="Masukkan Kata Kunci">
                                    <div class="form-text">
                                        Pencarian Nama Pekerjaan, Jenis Pekerjaan, Nama Perusahaan, Lokasi
                                    </div>
                                </div>
                                <div class="my-2">
                                    <label for="" class="form-label fw-semibold">Jenis Pekerjaan</label>
                                    <select name="selectQuery" class="form-select">
                                        <option value="" disabled selected>Pilih Jenis Pekerjaan</option>
                                        <option value="WFH">WFH</option>
                                        <option value="WFO">WFO</option>
                                        <option value="Hybrid">Hybrid</option>
                                    </select>
                                </div>
                                <div class="my-3 d-flex justify-content-end">
                                    <button class="btn btn-outline-dark">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
