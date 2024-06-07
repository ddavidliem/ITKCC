@extends('layouts.mail')

@section('content')
    <div>
        <h6>Halo {{ $approval->nama_lengkap }}</h6>
        <br>
        <p>Kami senang memberitahu Anda bahwa permohonan akun perusahaan Anda telah diterima oleh Admin.</p>
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
        <p>Silahkan melakukan verifikasi email pada halaman login employer. <br>
            Jika anda memiliki pertanyaan atau memerlukan bantuan, silahkan menghubungi tim Pusat Karir ITK.
        </p>
        <br>
        <p>Terima kasih atas kepercayaan Anda.</p>
        <br>
        <p>Tim Pusat Karir ITK</p>
    </div>
@endsection
