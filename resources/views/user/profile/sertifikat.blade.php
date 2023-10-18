@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="d-flex">
            <div class="col-lg-9 px-2">
                <div class="bg-white rounded border min-vh-75 p-4">
                    <h3 class="fw-semibold mb-4">Sertifikat</h3>
                    <div class="list-group list-group-flush" id="modalList">
                        @if ($new_sertifikat->isEmpty())
                            @include('component.empty', ['message' => 'Tidak Ditemukan Sertifikat'])
                        @endif
                        @foreach ($new_sertifikat as $item)
                            <div class="list-group-item p-2">
                                <div class="d-flex justify-content-between">
                                    <h5 class="text-capitalize fw-semibold">{{ $item->title }}</h5>
                                    <div>
                                        <small class="px-2"><a href="" type="button"
                                                class="text-decoration-none text-muted"
                                                data-bs-target="#editModal-{{ $item->id }}"
                                                data-bs-toggle="modal">Edit</a></small>
                                        <small><a href="" type="button"
                                                class="text-decoration-none text-danger delete-button"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-url="/delete-sertifikat/{{ $item->id }}">Delete</a></small>
                                    </div>
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

                            <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="fw-bold">Edit Sertifikat Form</h4>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                aria-label="Close" data-url="/delete-sertifikat/{{ $item->id }}">
                                            </button>
                                        </div>
                                        <form action="/update-sertifikat/{{ $item->id }}" method="POST"
                                            class="pengalaman-form" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body min-vh-50 scroll-modal p-4">
                                                <div class="my-2">
                                                    <label for="title" class="form-label fw-semibold">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title"
                                                        placeholder="Title Pekerjaan" required autofocus
                                                        value="{{ $item->title }}">
                                                </div>

                                                <div class="my-2">
                                                    <label for="organisasi"
                                                        class="form-label fw-semibold">Organisasi</label>
                                                    <input type="text" class="form-control" id="organisasi"
                                                        name="organisasi" placeholder="Organisasi"
                                                        value="{{ $item->organisasi }}" required>
                                                </div>

                                                <div class="my-2 row d-flex justify-content-evenly">
                                                    <label for="" class="my-1 fw-semibold">Tanggal Terbit
                                                        Sertifikat</label>
                                                    <div class="col-lg-6">
                                                        <label for="bulan" class="fw-semibold form-label">Bulan</label>
                                                        <div class="col-10">
                                                            <select name="bulan_mulai" id="" class="form-select"
                                                                required>
                                                                <option value="" selected disabled>Bulan Terbit
                                                                </option>
                                                                <option value="1"
                                                                    @if ('January' == $item->bulan_terbit) selected @endif>
                                                                    Januari</option>
                                                                <option
                                                                    value="2"@if ('February' == $item->bulan_terbit) selected @endif>
                                                                    Februari</option>
                                                                <option
                                                                    value="3"@if ('March' == $item->bulan_terbit) selected @endif>
                                                                    Maret</option>
                                                                <option
                                                                    value="4"@if ('April' == $item->bulan_terbit) selected @endif>
                                                                    April</option>
                                                                <option
                                                                    value="5"@if ('May' == $item->bulan_terbit) selected @endif>
                                                                    Mei</option>
                                                                <option
                                                                    value="6"@if ('June' == $item->bulan_terbit) selected @endif>
                                                                    Juni</option>
                                                                <option
                                                                    value="7"@if ('July' == $item->bulan_terbit) selected @endif>
                                                                    Juli</option>
                                                                <option
                                                                    value="8"@if ('August' == $item->bulan_terbit) selected @endif>
                                                                    Agustus</option>
                                                                <option
                                                                    value="9"@if ('September' == $item->bulan_terbit) selected @endif>
                                                                    September</option>
                                                                <option
                                                                    value="10"@if ('October' == $item->bulan_terbit) selected @endif>
                                                                    Oktober</option>
                                                                <option
                                                                    value="11"@if ('November' == $item->bulan_terbit) selected @endif>
                                                                    November</option>
                                                                <option
                                                                    value="12"@if ('December' == $item->bulan_terbit) selected @endif>
                                                                    Desember</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="tahun_mulai"
                                                            class="col-2 form-label fw-semibold">Tahun</label>
                                                        <div class="col-10">
                                                            <select name="tahun_mulai" class="form-select year" required>
                                                                <option value="" selected disabled>Tahun Mulai
                                                                </option>
                                                                @foreach ($years as $year)
                                                                    <option value="{{ $year }}"
                                                                        @if ($year == $item->tahun_terbit) selected @endif>
                                                                        {{ $year }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-2 row d-flex justify-content-evenly">
                                                    <label for="" class="my-1 fw-semibold">Tanggal Berakhir
                                                        Sertifikat</label>
                                                    <div class="col-lg-6">
                                                        <label for="bulan" class=" form-label fw-semibold">Bulan</label>
                                                        <div class="col-10">
                                                            <select name="bulan_selesai" id=""
                                                                class="form-select end-date">
                                                                <option value="" selected disabled>Bulan Selesai
                                                                </option>
                                                                <option value="1"
                                                                    @if ('January' == $item->bulan_berakhir) selected @endif>
                                                                    Januari</option>
                                                                <option
                                                                    value="2"@if ('February' == $item->bulan_berakhir) selected @endif>
                                                                    Februari</option>
                                                                <option
                                                                    value="3"@if ('March' == $item->bulan_berakhir) selected @endif>
                                                                    Maret</option>
                                                                <option
                                                                    value="4"@if ('April' == $item->bulan_berakhir) selected @endif>
                                                                    April</option>
                                                                <option
                                                                    value="5"@if ('May' == $item->bulan_berakhir) selected @endif>
                                                                    Mei</option>
                                                                <option
                                                                    value="6"@if ('June' == $item->bulan_berakhir) selected @endif>
                                                                    Juni</option>
                                                                <option
                                                                    value="7"@if ('July' == $item->bulan_berakhir) selected @endif>
                                                                    Juli</option>
                                                                <option
                                                                    value="8"@if ('August' == $item->bulan_berakhir) selected @endif>
                                                                    Agustus</option>
                                                                <option
                                                                    value="9"@if ('September' == $item->bulan_berakhir) selected @endif>
                                                                    September</option>
                                                                <option
                                                                    value="10"@if ('October' == $item->bulan_berakhir) selected @endif>
                                                                    Oktober</option>
                                                                <option
                                                                    value="11"@if ('November' == $item->bulan_berakhir) selected @endif>
                                                                    November</option>
                                                                <option
                                                                    value="12"@if ('December' == $item->bulan_berakhir) selected @endif>
                                                                    Desember</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="tahun_selesai"
                                                            class="form-label fw-semibold">Tahun</label>
                                                        <div class="col-10">
                                                            <select name="tahun_selesai"
                                                                class="form-select year end-date">
                                                                <option value="" selected disabled>Tahun Berakhir
                                                                </option>
                                                                @foreach ($years as $year)
                                                                    <option
                                                                        value="{{ $year }}"@if ($year == $item->tahun_berakhir) selected @endif>
                                                                        {{ $year }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-2">
                                                    <label for="" class="form-label fw-semibold">ID
                                                        Sertifikat</label>
                                                    <input type="text" class="form-control" name="id_sertifikat"
                                                        value="{{ $item->id_sertifikat }}">
                                                </div>

                                                <div class="my-2">
                                                    <label for="" class="form-label fw-semibold">URL
                                                        Sertifikat</label>
                                                    <input type="text" class="form-control" name="url_sertifikat"
                                                        value="{{ $item->url_sertifikat }}">
                                                </div>

                                                <div class="my-3 d-flex justify-content-end">
                                                    <button class="btn btn-outline-dark">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        @endforeach

                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="fw-bold">Konfirmasi Penghapusan Sertifikat</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                            aria-label="close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6 class="fw-semibold">Konfirmasi Untuk Menghapus Sertifikat {{ $item->title }}
                                        </h6>
                                        <form method="POST" id="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <div class='d-flex justify-content-end'>
                                                <button class="btn btn-outline-danger">Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="p-4 bg-white rounded min-vh-25">
                    <img src="{{ asset('component/coaching-clinic.png') }}" class="img-fluid" alt="">
                    <h6 class="fw-bold text-center my-2">Mulai dari yang kecil aja dulu</h6>
                    <div class="my-4 d-flex justify-content-center">
                        <a href="/konsultasi" class="btn btn-outline-dark">Make Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.pengalaman-form');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();

        document.addEventListener("DOMContentLoaded", function() {
            const deleteBtn = document.querySelectorAll('.delete-button');
            const deleteForm = document.getElementById('deleteForm');
            Array.from(deleteBtn).forEach(deleteBtn => {
                deleteBtn.addEventListener('click', function() {
                    deleteForm.setAttribute("action", deleteBtn.getAttribute('data-url'));
                });
            });
        });
    </script>
@endpush
