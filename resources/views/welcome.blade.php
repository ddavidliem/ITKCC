@extends('layouts.app')

@section('content')
    <div id="carouselITKCC" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselITKCC" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselITKCC" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselITKCC" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" id="carousel-inner">
            @foreach ($carousel as $key => $item)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('content/' . $item->image) }}" class="img-fluid w-100" alt="...">
                    @if (isset($item->body))
                        <div class="carousel-caption d-none d-md-block text-black">
                            <h5>{{ $item->title }}</h5>
                            <p class="text-wrap">{{ $item->body }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselITKCC" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselITKCC" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="bg-white p-4">
        <h4 class="text-center fw-semibold">Lowongan Kerja Terbaru Minggu Ini</h4>
        <div class="my-4 d-flex justify-content-center">
            <a href="/loker" class="text-decoration-none text-black fw-semibold text-center">Lihat Selengkapnya</a>
        </div>
        <div class="my-4">
            <div class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner min-vh-40 p-2">
                    @foreach ($chunkLokers as $key => $chunk)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class=" d-flex justify-content-evenly">
                                @foreach ($chunk as $loker)
                                    <div class="col-3 p-4 row align-items-center shadow-lg rounded ">
                                        <div class="col-4 px-2 logo-container">
                                            <img src="{{ asset('logo/' . $loker->employer->logo_perusahaan) }}"
                                                class="img-fluid w-auto h-auto" alt="">
                                        </div>
                                        <div class="col-8 overflow-hidden">
                                            <h6 class="fw-semibold text-capitalize text-wrap text-truncate">
                                                {{ $loker->nama_pekerjaan }}
                                            </h6>
                                            <div>
                                                <ul class="list-unstyled text-mute text-capitalize">
                                                    <li class="form-text">{{ $loker->employer->nama_perusahaan }}</li>
                                                    <li class="form-text">{{ $loker->tipe_pekerjaan }} |
                                                        {{ $loker->jenis_pekerjaan }}</li>
                                                </ul>
                                                <div>
                                                    <a href="/loker/{{ $loker->id }}"
                                                        class="btn btn-outline-dark">Selengkapnya</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white min-vh-40">
        <h4 class="fw-semibold text-center">Bimbingan Karir</h4>
        <div class=" d-flex justify-content-center">
            <div class="col-10">
                <p class="text-wrap">Dalam rangka membantu mahasiswa mempersiapkan diri untuk memasuki dunia kerja yang
                    kompetitif, Institut
                    Teknologi Kalimantan membuka Layanan Konsultasi Karir. Layanan Konsultasi Karir ITK terbuka untuk
                    seluruh mahasiswa, alumni, serta non-alumni yang telah bekerja. Layanan ini akan membantu para mahasiswa
                    dan fresh graduate dalam mempersiapkan karir sedini mungkin. Sementara untuk alumni maupun non-alumni
                    yang telah bekerja, layanan ini dapat membantu mengembangkan karir selanjutnya.</p>
                </p>
            </div>
        </div>
        <div class="my-4 d-flex justify-content-center">
            <div>
                <h5 class="fw-bold text-center">
                    Jadwal Konsultasi
                </h5>
                <h6 class="fw-semibold">
                    Setiap Hari Kerja | Gedung A ITK | Pukul : 07.30-15.30 WITA
                </h6>
            </div>
        </div>
    </div>
@endsection
