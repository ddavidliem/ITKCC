@extends('layouts.mail')

@section('content')
    <div>
        <h6>Halo {{ $approval->nama_lengkap }}</h6>
        <br>
        <p>Maaf, permohonan akun perusahaan Anda telah ditolak oleh Admin.</p>
        <br>
        <p>Berikut adalah detail perusahaan:</p>
        <ul>
            <li>Nama Perusahaan: {{ $approval->nama_perusahaan }}</li>
            <li>Alamat Perusahaan: {{ $approval->alamat }}</li>
            <li>Website Perusahaan: {{ $approval->website }}</li>
        </ul>
        <br>
        <p>Berikut adalah detail pemohon:</p>
        <ul>
            <li>Nama Lengkap: {{ $approval->nama_lengkap }}</li>
            <li>jabatan: {{ $approval->jabatan }}</li>
        </ul>
        <br>
        <h5>Alasan Di Tolak</h5>
        <br>
        <p>{{ $feedback }}</p>
        <br>
        <p>Jika Anda memiliki pertanyaan lebih lanjut atau ingin mengajukan ulang, silahkan menghubungi Tim Pusat Karir ITK
        </p>
        <br>
        <p>Terima kasih atas pengertian Anda.</p>
        <br>
        <br>
        <p>Tim Pusat Karir ITK</p>
    </div>
@endsection
