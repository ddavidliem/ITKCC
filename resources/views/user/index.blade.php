@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="">
            <div class="p-4 bg-white rounded min-vh-100">
                <div class="min-vh-25 mb-4">
                    <h5 class="fw-bold">Appointment Terbaru
                        @if ($appointment->isEmpty())
                            <span class="badge text-bg-warning">!</span>
                        @endif
                    </h5>
                    @if ($appointment->isEmpty())
                        <div class="d-flex justify-content-center">
                            <div class="align-self-center">
                                <h5 class="">Tidak Ada Appointment</h5>
                            </div>
                        </div>
                    @else
                        <div class="list-group list-group-flush px-4">
                            @foreach ($appointment as $item)
                                <a href="/Home/User/Appointment/{{ $item->id }}"
                                    class="my-3 text-decoration-none text-dark list-group-item">
                                    <h5 class="fw-bold">Appointment</h5>
                                    <div class="my-2">
                                        <h6 class="fw-semibold">{{ $item->topik }}</h6>
                                        <h6 class="text-capitalize">{{ $item->date_time }} |
                                            {{ $item->tempat_konseling }} |
                                            {{ $item->jenis_konseling }}</h6>
                                        <h6 class="fw-semibold">Status :
                                            @if ($item->status === 'Pending')
                                                <span class="fw-bold text-center py-1 px-2 ">
                                                    {{ $item->status }}</span>
                                            @elseif($item->status === 'Reschedule')
                                                <span class="fw-bold text-center bg-warning py-1 px-2 ">
                                                    {{ $item->status }}</span>
                                            @elseif($item->status === 'Approved')
                                                <span class="fw-bold text-center bg-primary py-1 px-2 ">
                                                    {{ $item->status }}</span>
                                            @endif
                                        </h6>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="min-vh-25 mb-4">
                    <h5 class="fw-bold">Application Terbaru
                        @if ($application->isEmpty())
                            <span class="badge text-bg-warning">!</span>
                        @endif
                    </h5>
                    @if ($application->isEmpty())
                        <div class="d-flex justify-content-center">
                            <div class="align-self-center">
                                <h5 class="">Tidak Ada Application</h5>
                            </div>
                        </div>
                    @else
                        <div class="list-group list-group-flush px-4">
                            @foreach ($application as $item)
                                <a href="/Home/User/Application/{{ $item->id }}"
                                    class="my-3 text-decoration-none text-dark list-group-item">
                                    <div class="d-flex">
                                        <div class="col-1">
                                            <img src="{{ asset('logo/' . $item->loker->employer->logo_perusahaan) }}"
                                                class="img-fluid" alt="">
                                        </div>
                                        <div class="col-11 mx-4">
                                            <h5 class="fw-semibold text-capitalize">{{ $item->loker->nama_pekerjaan }}
                                            </h5>
                                            <h6 class="fw-semibold">{{ $item->loker->employer->nama_perusahaan }}</h6>
                                            <h6 class="text-capitalize">{{ $item->loker->lokasi_pekerjaan }} |
                                                {{ $item->loker->jenis_pekerjaan }} |
                                                {{ $item->loker->tipe_pekerjaan }}</h6>
                                            <h6>Submitted At : {{ $item->created_at }}</h6>
                                            <h6 class="text-capitalize">
                                                Status :
                                                @if ($item->status === 'Pending')
                                                    <span>Pending</span>
                                                @elseif($item->status === 'Qualified')
                                                    <span class="text-success">Qualified</span>
                                                @elseif($item->status === 'Not Qualified')
                                                    <span class="text-danger">Not Qualified</span>
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="min-vh-25 mb-4">
                    <h5 class="fw-bold">Pengalaman Kerja Terbaru
                        @if ($pengalaman->isEmpty())
                            <span class="badge text-bg-warning">!</span>
                        @endif
                    </h5>
                    @if ($pengalaman->isEmpty())
                        <div class="d-flex justify-content-center">
                            <div class="align-self-center">
                                <h5 class="">Tidak Ada Pengalaman Kerja</h5>
                            </div>
                        </div>
                    @else
                        <div class="list-group list-group-flush px-4">
                            @foreach ($pengalaman as $item)
                                <div class="list-group-item">
                                    <h5 class="fw-semibold">{{ $item->title }}</h5>
                                    <div class="my-2">
                                        <h6 class="fw-semibold">{{ $item->organisasi }}</h6>
                                        <h6 class="text-capitalize">{{ $item->lokasi_pekerjaan }}</h6>
                                        <h6 class="">
                                            <span class="text-capitalize">
                                                {{ $item->tanggal_mulai }}
                                                @if ($item->tanggal_selesai)
                                                    | {{ $item->tanggal_selesai }}
                                                @endif
                                            </span>

                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="min-vh-25 mb-4">
                    <h5 class="fw-bold">Sertifikat Terbaru
                        @if ($sertifikat->isEmpty())
                            <span class="badge text-bg-warning">!</span>
                        @endif
                    </h5>
                    @if ($sertifikat->isEmpty())
                        <div class="d-flex justify-content-center">
                            <div class="align-self-center">
                                <h5 class="">Tidak Ada Sertifikat</h5>
                            </div>
                        </div>
                    @else
                        <div class="list-group list-group-flush px-4">
                            @foreach ($sertifikat as $item)
                                <div class="list-group-item">
                                    <h5 class="fw-semibold">{{ $item->title }}</h5>
                                    <div class="my-2">
                                        <h6 class="fw-semibold">{{ $item->organisasi }}</h6>
                                        <h6 class="">
                                            <span class="text-capitalize">
                                                {{ $item->tanggal_terbit }}
                                                @if ($item->tanggal_berakhir)
                                                    | {{ $item->tanggal_berakhir }}
                                                @endif
                                            </span>

                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>


    @endsection
