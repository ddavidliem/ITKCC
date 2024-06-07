@extends('layouts.mail')

@section('content')
    <div>
        <h6>Halo {{ $approval->nama_lengkap }}</h6>
        <br>
        <p>Kami mengucapkan terima kasih atas minat dan kepercayaan Anda untuk mendaftar sebagai penyedia kerja.</p>
        <br>
        <p>Berikut adalah ringkasan informasi yang kami terima.</p>
        <br>
        <p>Detail Perusahaan:</p>
        <ul>
            <li>Nama Perusahaan: {{ $approval->nama_perusahaan }}</li>
            <li>Alamat Perusahaan: {{ $approval->alamat }}</li>
            <li>Website Perusahaan: {{ $approval->website }}</li>
        </ul>
        <br>
        <p>Detail Pemohon:</p>
        <ul>
            <li>Nama Lengkap: {{ $approval->nama_lengkap }}</li>
            <li>Jabatan: {{ $approval->jabatan }}</li>
            <li>Nomor Telepon: {{ $approval->nomor_telepon }}</li>
            <li>Alamat Email: {{ $approval->alamat_email }}</li>
        </ul>
        <br>
        <p>Permohonan Anda telah diterima dan dalam proses peninjauan oleh tim kami.
            <br> Kami akan menghubungi jika permohonan Anda telah disetujui atau jika kami memerlukan informasi tambahan.
        </p>
        <br>
        <p>Jika ada pertanyaan atau bantuan lebih lanjut, silahkan menghubungi tim Pusat Karir ITK.</p>
        <br>
        <p>Terima kasih atas pengertian Anda.</p>
        <br>
        <p>Tim Pusat Karir ITK</p>
    </div>
@endsection
