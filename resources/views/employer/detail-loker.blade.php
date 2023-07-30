@extends('layouts.employer')

@section('content')
    <div class="p-4">
        <div class="min-vh-15 p-4 bg-white rounded">
            <div class="d-flex">
                <div class="d-flex col-lg-9">
                    <div class="">
                        <img src="{{ asset('logo/' . $loker->employer->logo_perusahaan) }}" alt=""
                            style="width:100px;height:70px">
                    </div>
                    <div class="mx-3">
                        <div>
                            <span class="fs-4 text-capitalize">{{ $loker->nama_pekerjaan }}</span>
                        </div>
                        <div>
                            <span class="fs-6 text-capitalize fw-semibold">{{ $loker->nama_perusahaan }}</span>
                            <br>
                            <span> <small class="text-capitalize">{{ $loker->lokasi_pekerjaan }}</small>
                                | <small class="text-capitalize">{{ $loker->jenis_pekerjaan }}</small>
                                | {{ $loker->created_at->diffForHumans() }}</span>
                            <br>
                            <span>{{ $loker->applicants_count }} Pelamar</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 d-flex justify-content-end">
                    <div>
                        <a href="" class="btn btn-primary fw-semibold">Edit Loker</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="min-vh-100 p-3 rounded my-4 d-flex">
            <div class="col-lg-4 bg-white rounded p-2 max-vh-100 overflow-auto">
                <div class=" list-group list-group-flush" role="tablist" id="tablist">
                    @if ($applications->isEmpty())
                        @include('component.empty')
                    @else
                        @foreach ($applications as $item => $applicant)
                            <a href="" type="button" role="tab" data-bs-toggle="tab"
                                data-bs-target="#tab-{{ $applicant->id }}" aria-controls="{{ $applicant->id }}"
                                class="list-group-item p-2 d-flex rounded" data-toggle="tab">
                                <div>
                                    <img src="{{ asset('profile/' . $applicant->user->profile) }}" alt=""
                                        style="width: 75px">
                                </div>
                                <div class="mx-2">
                                    <span class="fs-5">{{ $applicant->user->nama_lengkap }}</span>
                                    <br>
                                    <small>{{ $applicant->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        @endforeach
                    @endif

                </div>

            </div>
            <div class="col-lg-8 px-2 tab-content" id="tab-content">
                @foreach ($applications as $item => $applicant)
                    <div id="tab-{{ $applicant->id }}" class="p-2 tab-pane" role="tabpanel">
                        <div class="bg-white p-4 min-vh-10 mb-3">
                            <div>
                                <h4 class="fw-semibold text-capitalize">{{ $applicant->user->nama_lengkap }}</h4>
                                <small>{{ $applicant->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="my-3 d-flex">
                                <button class="btn btn-primary" type="button" role="button">Approve</button>
                                <button class="btn btn-secondary" type="button" role="button">Send Feedback</button>
                            </div>
                        </div>
                        @if ($applicant->user->sertifikasi)
                            <div class="p-4 bg-white rounded">
                                <h3 class="fw-semibold">Sertifkat</h3>
                                <div class="list-group list-group-flush">
                                    @foreach ($applicant->user->sertifikasi as $item)
                                        <div class="list-group-item">
                                            <h5>{{ $item->judul_sertifikasi }}</h3>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="p-4 bg-white rounded">
                            <h3>Resume</h3>
                            <div class="d-flex justify-content-center">
                                <iframe src="{{ asset('resume/' . $applicant->user->resume) }}" frameborder="0"
                                    class="my-4" width="100%" height="600px"></iframe>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@push('script')
@endpush
