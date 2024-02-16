@extends('layouts.mail')

@section('content')
    <div class="p-4 container">
        <div class="">
            <h1>Notifikasi Appointment Konseling Karir</h1>
            <div class="my-4">
                <h3>Halo, {{ $appointment->user->nama_lengkap }}</h3>
                <p>Permohonan Konseling Anda Telah Diproses Admin Pusat Karir ITK. Berikut Detail Appointment:</p>
                <div class="my-3">
                    <ul>
                        <li>Tanggal dan Waktu: <span>{{ $appointment->date_time }}</span></li>
                        <li>Topik: <span class="text-capitalize">{{ $appointment->topik }}</span></li>
                        <li>Tempat Konseling: <span class="text-capitalize">{{ $appointment->tempat_konseling }}</span></li>
                        <li>Jenis Konselinlg: <span class="text-capitalize">{{ $appointment->jenis_konseling }}</span></li>
                        <li>Status: <span class="text-capitalize">{{ $appointment->status }}</span></li>
                    </ul>
                </div>
                @if ($appointment->status == 'Accepted')
                    <h4>Silahkan Melakukan Konfirmasi Di Web Pusat Karir</h4>
                @elseif($appointment->status == 'Reschedule')
                    <h4>Silahkan Mengubah Jadwal, Di Web Pusat Karir</h4>
                @endif
                <div class="my-2">
                    <h4>Jika anda masih memiliki pertanyaan atau perlu mengubah atau membatalkan konseling, jangan ragu
                        untuk menghubungi Tim Pusat Karir</h4>
                    <h4>Terimakasih,</h4>
                    <h4>Tim Pusat karir ITK</h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
@endpush
