@extends('layouts.mail')

@section('content')
    <div class="p-4 container">
        <div class="bg-white rounded p-4 min-vh-50">
            <h1 class="fw-semibold">Link Verifikasi Email</h1>
            <div class="my-4">
                <h6>Klik Link Di Bawah Ini Untuk Melakukan Verifikasi Email</h6>
                <a href="http://127.0.0.1:8000/verify-email/{{ $token }}" class="btn btn-outline-dark">Verifikasi
                    Email</a>
                <div class="form-text">
                    Jika Tidak Melakukan Verikasi Email, Abaikan Saja Email Ini Atau Melaporkan Pada Tim Pusat Karir ITK
                </div>
            </div>
        </div>
    </div>
@endsection
