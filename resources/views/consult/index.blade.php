@extends('layouts.app')

@section('content')
    <div class="p-4 min-vh-100 bg-white">
        <div class="p-4 col-8 offset-2">
            <img src="{{ asset('component/coaching-clinic.png') }}" class="img-fluid" alt="">
        </div>
        <div class="my-4">
            <h4 class="fw-semibold text-center">Bimbingan Karir</h4>
            <div class="my-4 p-4 col-8 offset-2">
                <p class="text-mute text-wrap">
                    Dalam rangka membantu mahasiswa mempersiapkan diri untuk memasuki dunia kerja yang kompetitif, Institut
                    Teknologi Kalimantan membuka Layanan Konsultasi Karir. Layanan Konsultasi Karir ITK terbuka untuk
                    seluruh mahasiswa, alumni, serta non-alumni yang telah bekerja. Layanan ini akan membantu para mahasiswa
                    dan fresh graduate dalam mempersiapkan karir sedini mungkin. Sementara untuk alumni maupun non-alumni
                    yang telah bekerja, layanan ini dapat membantu mengembangkan karir selanjutnya.
                </p>
            </div>
        </div>
        <div class="my-4">
            <div class="my-4 p-2 col-8 offset-2">
                <h4 class="fw-bold text-center my-4">Layanan Konseling Karir ITK</h4>
                <div class="carousel shadow-lg slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="min-vh-35 rounded my-4 p-4 d-flex align-items-center justify-content-between">
                                <div class="col-2 p-2">
                                    <img src="{{ asset('content/users.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-10 p-3">
                                    <h5 class="fw-semibold">Konseling Pribadi</h5>
                                    <p class="text-mute text-wrap">
                                        jangan biarkan masalah pribadi menghambat potensi anda. Melalui pendampingan dari
                                        layanan konseling pribadi kami, jalani perubahan positif, dapatkan wawasan, dan
                                        capai potensi terbaik dalam diri kamu.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="min-vh-35 rounded my-4 p-4 d-flex align-items-center justify-content-between">
                                <div class="col-2 p-2">
                                    <img src="{{ asset('content/group.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-10 p-3">
                                    <h5 class="fw-semibold">Konseling Kelompok</h5>
                                    <p class="text-mute">
                                        Konseling kelompok mengajak kalian untuk meraih keberhasilan bersama. Jalin ikatan
                                        yang kokoh dan bagikan perjalanan karier dengan teman-teman sejawat. Temukan
                                        inspirasi, dukungan, dan solusi dalam eksplorasi karier bersama-sama untuk mencapai
                                        tujuan bersama.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <div class="min-vh-35 rounded my-4 p-4 d-flex align-items-center justify-content-between">
                                <div class="col-2 p-2">
                                    <img src="{{ asset('content/career.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-10 p-3">
                                    <h5 class="fw-semibold">Konseling Karir / Study</h5>
                                    <p class="text-mute">
                                        Jembatani perjalanan karier dan studi Anda dengan dukungan konseling kami. Temukan
                                        arah tepat menuju kesuksesan pendidikan dan karier Anda melalui panduan ahli kami.
                                        Kami adalah kunci membuka peluang baru dan membimbing Anda menuju tujuan pendidikan
                                        serta karier.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <div class="min-vh-35 rounded my-4 p-4 d-flex align-items-center justify-content-between">
                                <div class="col-2 p-2">
                                    <img src="{{ asset('content/clock.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="col-10 p-3">
                                    <h5 class="fw-semibold">Waktu Layanan</h5>
                                    <p class="text-mute">
                                        Jam 07.30-12.00, 13.00-15.30 WITA
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center my-4">
            <div>
                <div class="my-2">
                    <h4 class="fw-semibold text-center">Daftarkan Dirimu Disini !</h4>
                </div>
                <a href="/register-user-form" class="text-decoration-none btn btn-outline-dark py-2 px-3 fs-5">Bergabung
                    di
                    Pusat Karir
                    ITk</a>
            </div>
        </div>
    </div>
@endsection
