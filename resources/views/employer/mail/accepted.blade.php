@extends('layouts.mail')

@section('content')
    <div>
        <p>Kepada {{ $application->nama_lengkap }}</p>
        <p>Kami dengan senang hati menginformasikan bahwa lamaran anda untuk posisi
            {{ $application->loker->nama_pekerjaan }}
            di perusahaan kami telah berhasil lolos seleksi berkas</p>
        <ul>
            <li>Nama Posisi: {{ $application->loker->nama_pekerjaan }}</li>
            <li>Nama Perusahaan: {{ $application->loker->employer->nama_perusahaan }}</li>
            <li>Tanggal Lamaran: {{ $application->created_at->format('d-m-Y') }}</li>
        </ul>
        <p>Informasi lebih lanjut mengenai tahapan selanjutnya akan disampaikan dalam waktu dekat.</p>
        <p>Terima kasih atas minat dan partisipasi anda.
            <br>
            Salam,
            {{ $application->loker->employer->nama_lengkap }}
            <br>
            {{ $application->loker->employer->jabatan }}
            <br>
            {{ $application->loker->employer->nama_perusahaan }}
        </p>
    </div>
@endsection
