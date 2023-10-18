@extends('layouts.mail')

@section('content')
    <div class="p-4 container">
        <div class="bg-white rounded p-4 min-vh-50">
            <h1 class="fw-semibold">Approval Notification</h1>
            <div class="my-4">
                <h6>Terimakasih Telah Mendaftar</h6>
                <div class="my-2">
                    <p>Permohonan Pendaftaran Telah Diterima Oleh Tim Pusat Karir ITK</p>
                    <h6 class="">Nomor Permohonan <span class="fw-semibold">{{ $approval->id }}</span></h6>
                    <ul class="list-unstyled">
                        <li>{{ $approval->nama_perusahaan }}</li>
                        <li>{{ $approval->nama_lengkap }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
