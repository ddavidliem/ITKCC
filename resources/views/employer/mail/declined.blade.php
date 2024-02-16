@extends('layouts.mail')

@section('content')
    <div>
        <p>Kepada {{ $application->nama_lengkap }}</p>
        <p>Setelah meninjau lamaran anda untuk posisi {{ $application->loker->nama_pekerjaan }} di perusahaan kami, dengan
            ini kami informasikan bahwa lamaran anda tidak berhasil melalui tahap seleksi berkas</p>
        <ul>
            <li>Nama Posisi: {{ $application->loker->nama_pekerjaan }}</li>
            <li>Nama Perusahaan: {{ $application->loker->employer->nama_perusahaan }}</li>
            <li>Tanggal Lamaran: {{ $application->created_at->format('d-m-Y') }}</li>
        </ul>
        <p>
            Meskipun tidak berhasil pada tahap ini, kami mengucapkan terimakasih atas minat dan partisipasi anda,
            kami menghargai waktu dan usaha anda tempatkan untuk melamar di perusahaan kami.
        </p>
        <p>
            Terimakasih kembali atas partisipasi anda.
            <br>
            Salam,
            <br>
            {{ $application->loker->employer->nama_lengkap }}
            <br>
            {{ $application->loker->employer->jabatan }}
            <br>
            {{ $application->loker->employer->nama_perusahaan }}
        </p>
    </div>
@endsection
