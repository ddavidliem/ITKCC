@extends('layouts.mail')

@section('content')
    <div class="p-4 container">
        <div class="bg-white rounded p-4 min-vh-50">
            <h1 class="fw-semibold">Approval Notification Update</h1>
            <div class="my-4">
                <h6>Permohonan Anda Telah Diproses oleh Admin</h6>
                <div class="my-2">
                    @if ($approval->status === 'approved')
                        <h6>Status Permohonan : <span class="fw-semibold">Diterima</span></h6>
                    @elseif($approval->status === 'not approved')
                        <h6>Status Permohonan : <span class="fw-semibold">Tidak Diterima</span></h6>
                    @endif
                </div>
                <div class="my-2">
                    <ul class="list-unstyled">
                        <li>
                            <h6>Nama Perusahaan : <span
                                    class="fw-semibold text-capitalize">{{ $approval->nama_perusahaan }}</span></h6>
                        </li>
                        <li>
                            <h6>Alamat Email : <span class="fw-semibold">{{ $approval->alamat_email }}</span></h6>
                        </li>
                        <li>
                            <h6>Nama Lengkap : <span
                                    class="fw-semibold text-capitalize">{{ $approval->nama_lengkap }}</span></h6>
                        </li>
                    </ul>
                </div>
                <div class="my-2">
                    @if ($approval->status === 'approved')
                        <h6>Silahkan Melakukan Verifikasi Email Pada Halaman Login</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
