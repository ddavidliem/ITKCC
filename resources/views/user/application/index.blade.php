@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="d-flex">
            <div class="col-9">
                <div class="bg-white rounded p-4 min-vh-100">
                    <h4 class="fw-bold">Application</h4>
                    <div class="my-4">
                        <div class="list-group list-group-flush">
                            @foreach ($application as $item)
                                <div class="list-group-item">
                                    <a href="/Home/User/Application/{{ $item->id }}"
                                        class="my-3 text-decoration-none text-dark">
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
                                    <div>
                                        <ul class="list-unstyled">
                                            @if (!empty($item->feedback))
                                                <li><a href="" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#description-{{ $item->id }}"aria-expanded="false"
                                                        class="text-decoration-none text-muted">Feedback</a></li>
                                                <li>
                                                    <div class="collapse" id="description-{{ $item->id }}">
                                                        <p>{!! nl2br($item->feedback) !!}</p>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 mx-2">
                <div class="bg-white rounded p-4 min-vh-25">
                    <div class="">
                        <img src="{{ asset('component/coaching-clinic.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="my-2">
                        <h6 class="fw-semibold text-center">Belum Dapat Pekerjaan Yang Cocok? <br>
                            Atau Belum Dapat Kesempatan Kerja?<br>
                            Konseling Aja Dulu
                        </h6>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="/konsultasi" class="btn btn-outline-dark">Make Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
