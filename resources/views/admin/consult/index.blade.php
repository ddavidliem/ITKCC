@extends('layouts.app')

@section('content')
    <div class="bg-white min-vh-100 ">
        <div class="d-flex min-vh-50 align-items-center bg-primary">
            <div class="col-lg-7 p-4 text-white d-flex align-items-center">
                <img src="{{ asset('img/logo_itk.png') }}" class="" style="width: 140px" alt="">
                <div class="p-4 col">
                    <h1>Institut Teknologi Kalimantan</h1>
                    <p class="fs-2">Pusat Pengembangan Karir</p>
                </div>
            </div>
            <div class="col-lg-5 p-4 ">
                <p class="fs-4 text-white">
                    Pusat Pengembangan Karir Institut Teknologi Kalimantan membuka Coaching Clinic secara daring bagi para
                    calon
                    lulusan dan alumni ITK.
                </p>
                <ul class="fs-5 text-white">
                    <li>Pembuatan CV & Cover Letter</li>
                    <li>Menghadapi Psikotes, Wawancara Kerja, LGD</li>
                    <li>Perencanaan Karir</li>
                    <li>Pemahaman Minat dan Kemampuan dalam bekerja</li>
                </ul>
            </div>
        </div>

        <div class=" p-4 min-vh-50">
            <div class=" col-lg-10 offset-1">
                <a href="/appointment-form" class="btn btn-primary fs-3 col-lg-8 offset-2  rounded :hover">Make
                    Appointment</a>
            </div>
            <div class="col-lg-10 offset-1 d-flex justify-content-center">
                <div>
                    <img src="" alt="">
                </div>
                <div>
                    <h2></h2>
                </div>
            </div>
        </div>


    </div>
@endsection
