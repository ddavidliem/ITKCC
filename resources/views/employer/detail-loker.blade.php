@extends('layouts.employer')

@section('content')
    <div class="p-4 d-flex">
        <div class="col-3">
            <div class="rounded bg-white p-4 min-vh-15 d-flex">
                <div class="col-2">
                    <img src="{{ asset('logo/' . $loker->employer->logo_perusahaan) }}" class="img-fluid" alt="">
                </div>
                <div class="col-7 mx-3">
                    <h6 class="fw-semibold text-capitalize">{{ $loker->nama_pekerjaan }}</h6>
                    <ul class="list-unstyled">
                        <li class="fw-semibold text-capitalize">{{ $loker->employer->nama_perusahaan }}</li>
                        <li class="text-capitalize">{{ $loker->lokasi_pekerjaan }}</li>
                        <li class="text-capitalize">{{ $loker->jenis_pekerjaan }}</li>
                        <li class="text-capitalize">

                        </li>
                    </ul>
                    <div class="d-flex">
                        <button class="btn btn-outline-danger" data-bs-target="#deleteLokerModal"
                            data-bs-toggle="modal">Delete</button>
                        <button class="btn btn-outline-dark mx-1" data-bs-target="#editLokerModal"
                            data-bs-toggle="modal">Edit</button>
                    </div>
                </div>
                <div class="col-3">
                    <h6 class="fw-semibold">Status</h6>
                    @if ($loker->status == 'Open')
                        <h5 class="my-4 align-self-center text-success">{{ $loker->status }}</h5>
                    @elseif($loker->status == 'Closed')
                        <h5 class="my-4 align-self-center text-danger">{{ $loker->status }}</h5>
                    @endif

                </div>
            </div>

            <div class="my-4 min-vh-10 bg-white rounded p-3">
                <form class="" role="search" method="GET">
                    <div class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit">Search</button>
                    </div>
                    <div class="d-flex justify-content-evenly my-2">
                        <div>
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Qualified
                            </label>
                        </div>
                        <div class="mx-2">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Not Qualified
                            </label>
                        </div>
                        <div class="mx-2">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Pending
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="my-4 rounded bg-white p-3 min-vh-75 max-vh-100 overflow-auto">
                <div class=" list-group list-group-flush" role="tablist" id="tablist">
                    @if ($applications->isEmpty())
                        @include('component.empty', ['message' => 'Belum Ada Pelamar'])
                    @else
                        @foreach ($applications as $item => $applicant)
                            <a href="" type="button" role="tab" data-bs-toggle="tab"
                                data-bs-target="#tab-{{ $applicant->id }}" aria-controls="{{ $applicant->id }}"
                                class="list-group-item p-2 d-flex rounded" data-toggle="tab">
                                <div class="col-2">
                                    <img src="{{ asset('profile/' . $applicant->user->profile) }}" class="img-fluid"
                                        alt="">
                                </div>
                                <div class="col-7 mx-2">
                                    <h6 class="fw-semibold my-2">{{ $applicant->user->nama_lengkap }}</h6>
                                    <ul class="list-unstyled">
                                        <li>{{ $applicant->user->nim }}</li>
                                        <li>{{ $applicant->user->kota }}</li>
                                        <li>{{ $applicant->created_at }}</li>
                                    </ul>
                                </div>
                                <div class="col-3">
                                    <h6 class="">{{ $applicant->status }}</h6>
                                </div>
                            </a>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>

        <div class="col-9 mx-3">
            <div class="rounded bg-white min-vh-150 p-4">
                <div class="tab-content" id="tab-content">
                    @foreach ($applications as $item => $applicant)
                        <div id="tab-{{ $applicant->id }}" class="p-2 tab-pane" role="tabpanel">
                            <div class="bg-white p-4 min-vh-10 mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <h3 class="fw-bold">Biodata Pelamar</h3>
                                        @if ($applicant->status === 'Qualified')
                                            <h5 class="mx-4" class="text-success fw-semibold">Application Qualified</h5>
                                        @elseif($applicant->status === 'Not Qualified')
                                            <h5 class="mx-4" class="text-danger fw-semibold">Application Qualified</h5>
                                        @endif
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-dark status-button" data-bs-toggle="modal"
                                            data-bs-target="#applicationModal"
                                            data-url="/Employer/{{ $loker->id }}/applicant/{{ $applicant->id }}"
                                            data-content="{{ $applicant->user->nama_lengkap }}">Status</button>
                                    </div>
                                </div>
                                <div class="my-4 d-flex">
                                    <div class="col-2">
                                        <img src="{{ asset('profile/' . $applicant->user->profile) }}" class="img-fluid"
                                            alt="">
                                    </div>
                                    <div class="col-10 mx-4 d-flex">
                                        <div class="col-4">
                                            <div class="my-1">
                                                <label for="" class="form-label">Nama Lengkap</label>
                                                <h6 class="fw-semibold">{{ $applicant->user->nama_lengkap }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Email</label>
                                                <h6 class="fw-semibold">{{ $applicant->user->alamat_email }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Nomor Telepon</label>
                                                <h6 class="fw-semibold">{{ $applicant->user->nomor_telepon }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Kota</label>
                                                <h6 class="fw-semibold text-capitalize">{{ $applicant->user->kota }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Alamat</label>
                                                <h6 class="fw-semibold">{{ $applicant->user->alamat }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="my-1">
                                                <label for="" class="form-label">Tempat Kelahiran</label>
                                                <h6 class="fw-semibold text-capitalize">
                                                    {{ $applicant->user->tempat_lahir }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Tanggal Lahir</label>
                                                <h6 class="fw-semibold">{{ $applicant->user->tanggal_lahir }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Jenis Kelamin</label>
                                                <h6 class="fw-semibold text-capitalize">
                                                    {{ $applicant->user->jenis_kelamin }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Kewarganegaraan</label>
                                                <h6 class="fw-semibold text-capitalize">
                                                    {{ $applicant->user->kewarganegaraan }}</h6>
                                            </div>
                                            <div class="my-1">
                                                <label for="" class="form-label">Agama</label>
                                                <h6 class="fw-semibold text-capitalize">{{ $applicant->user->agama }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($applicant->user->sertifikat)
                                <div class="px-4">
                                    <h3 class="fw-bold">Sertifikat</h3>
                                    <div class="list-group list-group-flush">
                                        @foreach ($applicant->user->sertifikat as $item)
                                            <div class="list-group-item p-2">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="text-capitalize fw-semibold">{{ $item->title }}</h5>
                                                </div>
                                                <ul class="list-unstyled">
                                                    <li class="text-capitalize">{{ $item->organisasi }}</li>
                                                    <li class="text-capitalize">{{ $item->tanggal_terbit }} @if (!empty($item->tanggal_berakhir))
                                                            - {{ $item->tanggal_berakhir }}
                                                        @endif
                                                    </li>
                                                    @if (!empty($item->id_sertifikat))
                                                        <li>{{ $item->id_sertifikat }}</li>
                                                    @endif
                                                    @if (!empty($item->url_sertifikat))
                                                        <li>{{ $item->url_sertifikat }}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($applicant->user->pengalaman)
                                <div class="px-4">
                                    <h3 class="fw-bold">Pengalaman</h3>
                                    <div class="list-group list-group-flush">
                                        @foreach ($applicant->user->pengalaman as $item)
                                            <div class="list-group-item p-2">
                                                <h5 class="text-capitalize fw-semibold">{{ $item->title }}</h5>
                                                <ul class="list-unstyled">
                                                    <li class="text-capitalize">{{ $item->organisasi }} |
                                                        {{ $item->jenis_pekerjaan }}</li>
                                                    <li class="text-capitalize">{{ $item->tanggal_mulai }} -
                                                        {{ $item->tanggal_selesai }}
                                                    </li>
                                                    @if (!empty($item->deskripsi))
                                                        <li><a href="" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#description-{{ $item->id }}"aria-expanded="false"
                                                                class="text-decoration-none text-muted">Deskripsi
                                                                Pekerjaan</a></li>
                                                        <li>
                                                            <div class="collapse" id="description-{{ $item->id }}">
                                                                <p>{!! nl2br($item->deskripsi) !!}</p>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="px-4 my-4">
                                <h3 class="fw-bold">Resume</h3>
                                <div class="my-2">
                                    <iframe src="{{ asset('resume/' . $applicant->user->resume) }}" frameborder="0"
                                        class="my-4 w-100 min-vh-100"></iframe>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if ($applications)
        @include('employer.modal.application')
    @endif
    @include('employer.modal.loker-edit-form')
    @include('employer.modal.loker-delete-form')
@endsection

@push('script')
    <script type="module">
        (() => {
            'use strict';
            const modals = document.querySelectorAll('.modal');
            Array.from(modals).forEach(modal => {
                const forms = modal.querySelectorAll('.form-validate');
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (form.closest('.modal') === modal && !form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            });
        })();

        document.addEventListener("DOMContentLoaded", function() {
            const statusBtn = document.querySelectorAll('.status-button');
            const statusForm = document.getElementById('statusForm');
            const application = document.getElementById('applicationName');
            Array.from(statusBtn).forEach(statusBtn => {
                statusBtn.addEventListener('click', function() {
                    statusForm.setAttribute("action", statusBtn.getAttribute('data-url'));
                    application.innerHTML = statusBtn.getAttribute('data-content');
                });
            });
        });
    </script>
@endpush
