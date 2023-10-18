@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="d-flex">
            <div class="col-lg-9 px-2">
                <div class="bg-white rounded border min-vh-75 p-4">
                    <h3 class="fw-bold mb-3">Pengalaman</h3>
                    <div class="list-group list-group-flush" id="modalList">
                        @if ($new_Pengalaman->isEmpty())
                            @include('component.empty', ['message' => 'Tidak Ditemukan Pengalaman'])
                        @endif
                        @foreach ($new_Pengalaman as $item)
                            <div class="list-group-item p-2">
                                <div class="d-flex justify-content-between">
                                    <h4 class="text-capitalize fw-semibold">{{ $item->title }}</h4>
                                    <div>
                                        <small class="px-2"><a href="" type="button"
                                                class="text-decoration-none text-muted"
                                                data-bs-target="#editModal-{{ $item->id }}"
                                                data-bs-toggle="modal">Edit</a></small>
                                        <small><a href="" type="button"
                                                class="text-decoration-none text-danger delete-button"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-url="/delete-pengalaman/{{ $item->id }}">Delete</a></small>
                                    </div>

                                </div>
                                <ul class="list-unstyled">
                                    <li class="text-capitalize">{{ $item->organisasi }} | {{ $item->jenis_pekerjaan }}</li>
                                    <li class="text-capitalize">{{ $item->tanggal_mulai }} - {{ $item->tanggal_selesai }}
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

                            <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="fw-bold">Edit Pengalaman Form</h4>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <form action="/update-pengalaman/{{ $item->id }}" method="POST"
                                            class="pengalaman-form" novalidate>
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body min-vh-50 scroll-modal p-4">
                                                <div class="mb-2 mt-1">
                                                    <label for="title" class="form-label fw-semibold">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title"
                                                        placeholder="Title Pekerjaan" required autofocus
                                                        value="{{ $item->title }}">
                                                </div>
                                                <div class="my-2">
                                                    <label for="jenis_pekerjaan" class="form-label fw-semibold">Jenis
                                                        Pekerjaan</label>
                                                    <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-select"
                                                        required>
                                                        <option value="" selected disabled>Pilih Jenis Pekerjaan
                                                        </option>
                                                        <option value="Full Time"
                                                            @if ('Full Time' == $item->jenis_pekerjaan) selected @endif>
                                                            Full TIme</option>
                                                        <option
                                                            value="Part Time"@if ('Part Time' == $item->jenis_pekerjaan) selected @endif>
                                                            Part TIme</option>
                                                        <option
                                                            value="Freelance"@if ('Freelance' == $item->jenis_pekerjaan) selected @endif>
                                                            Freelance</option>
                                                        <option
                                                            value="Contract"@if ('Contract' == $item->jenis_pekerjaan) selected @endif>
                                                            Contract</option>
                                                        <option
                                                            value="Internship"@if ('Internship' == $item->jenis_pekerjaan) selected @endif>
                                                            Internship</option>
                                                        <option
                                                            value="Apprenticeship"@if ('Apprenticeship' == $item->jenis_pekerjaan) selected @endif>
                                                            Apprenticeship</option>
                                                    </select>
                                                </div>
                                                <div class="my-2">
                                                    <label for="organisasi"
                                                        class="form-label fw-semibold">Organisasi</label>
                                                    <input type="text" class="form-control" id="organisasi"
                                                        name="organisasi" placeholder="Organisasi"
                                                        value="{{ $item->organisasi }}" required>
                                                </div>
                                                <div class="my-2">
                                                    <label for="lokasi_pekerjaan" class="form-label fw-semibold">Lokasi
                                                        Pekerjaan</label>
                                                    <input type="text" class="form-control" id="lokasi_pekerjaan"
                                                        name="lokasi_pekerjaan"
                                                        placeholder="Balikpapan Selatan, Kalimantan Timur, Indonesia"
                                                        value="{{ $item->lokasi_pekerjaan }}" required>
                                                </div>

                                                <div class="my-3 row d-flex justify-content-evenly">
                                                    <label for="" class="my-2 fw-semibold">Tanggal Mulai
                                                        Bekerja</label>
                                                    <div class="col-lg-6">
                                                        <label for="bulan" class="form-label fw-semibold">Bulan</label>
                                                        <div class="col-10">
                                                            <select name="bulan_mulai" id="" class="form-select"
                                                                required>
                                                                <option value="" selected disabled>Bulan Mulai
                                                                </option>
                                                                <option value="1"
                                                                    @if ('January' == $item->bulan_mulai) selected @endif>
                                                                    Januari</option>
                                                                <option
                                                                    value="2"@if ('February' == $item->bulan_mulai) selected @endif>
                                                                    Februari</option>
                                                                <option
                                                                    value="3"@if ('March' == $item->bulan_mulai) selected @endif>
                                                                    Maret</option>
                                                                <option
                                                                    value="4"@if ('April' == $item->bulan_mulai) selected @endif>
                                                                    April</option>
                                                                <option
                                                                    value="5"@if ('May' == $item->bulan_mulai) selected @endif>
                                                                    Mei</option>
                                                                <option
                                                                    value="6"@if ('June' == $item->bulan_mulai) selected @endif>
                                                                    Juni</option>
                                                                <option
                                                                    value="7"@if ('July' == $item->bulan_mulai) selected @endif>
                                                                    Juli</option>
                                                                <option
                                                                    value="8"@if ('August' == $item->bulan_mulai) selected @endif>
                                                                    Agustus</option>
                                                                <option
                                                                    value="9"@if ('September' == $item->bulan_mulai) selected @endif>
                                                                    September</option>
                                                                <option
                                                                    value="10"@if ('October' == $item->bulan_mulai) selected @endif>
                                                                    Oktober</option>
                                                                <option
                                                                    value="11"@if ('November' == $item->bulan_mulai) selected @endif>
                                                                    November</option>
                                                                <option
                                                                    value="12"@if ('December' == $item->bulan_mulai) selected @endif>
                                                                    Desember</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="tahun_mulai"
                                                            class="form-label fw-semibold">Tahun</label>
                                                        <div class="col-10">
                                                            <select name="tahun_mulai" class="form-select year" required>
                                                                <option value="" selected disabled>Tahun Mulai
                                                                </option>
                                                                @foreach ($years as $year)
                                                                    <option value="{{ $year }}"
                                                                        @if ($year == $item->tahun_mulai) selected @endif>
                                                                        {{ $year }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-3">
                                                    <input type="checkbox" class="form-check-input modal-checkbox"
                                                        name="present_box" value="Present"
                                                        @if ($item->present == true) @checked(true) @endif>
                                                    <label for="" class="form-check-label fw-semibold">Present (
                                                        Saat Ini
                                                        Masih
                                                        Bekerja)</label>
                                                </div>

                                                <div class="my-3 row d-flex justify-content-evenly">
                                                    <label for="" class="my-2 form-label fw-semibold">Tanggal
                                                        Selesai Bekerja</label>
                                                    <div class="col-lg-6">
                                                        <label for="bulan"
                                                            class="col-2 form-label fw-semibold">Bulan</label>
                                                        <div class="col-10">
                                                            <select name="bulan_selesai" id=""
                                                                class="form-select end-date"
                                                                @if ($item->present == true) @disabled(true) @endif>
                                                                <option value="" selected disabled>Bulan Selesai
                                                                </option>
                                                                <option value="1"
                                                                    @if ('January' == $item->bulan_selesai) selected @endif>
                                                                    Januari</option>
                                                                <option
                                                                    value="2"@if ('February' == $item->bulan_selesai) selected @endif>
                                                                    Februari</option>
                                                                <option
                                                                    value="3"@if ('March' == $item->bulan_selesai) selected @endif>
                                                                    Maret</option>
                                                                <option
                                                                    value="4"@if ('April' == $item->bulan_selesai) selected @endif>
                                                                    April</option>
                                                                <option
                                                                    value="5"@if ('May' == $item->bulan_selesai) selected @endif>
                                                                    Mei</option>
                                                                <option
                                                                    value="6"@if ('June' == $item->bulan_selesai) selected @endif>
                                                                    Juni</option>
                                                                <option
                                                                    value="7"@if ('July' == $item->bulan_selesai) selected @endif>
                                                                    Juli</option>
                                                                <option
                                                                    value="8"@if ('August' == $item->bulan_selesai) selected @endif>
                                                                    Agustus</option>
                                                                <option
                                                                    value="9"@if ('September' == $item->bulan_selesai) selected @endif>
                                                                    September</option>
                                                                <option
                                                                    value="10"@if ('October' == $item->bulan_selesai) selected @endif>
                                                                    Oktober</option>
                                                                <option
                                                                    value="11"@if ('November' == $item->bulan_selesai) selected @endif>
                                                                    November</option>
                                                                <option
                                                                    value="12"@if ('December' == $item->bulan_selesai) selected @endif>
                                                                    Desember</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="tahun_selesai"
                                                            class="col-2 form-label fw-semibold">Tahun</label>
                                                        <div class="col-10">
                                                            <select name="tahun_selesai" class="form-select year end-date"
                                                                @if ($item->present == true) @disabled(true) @endif>
                                                                <option value="" selected disabled>Tahun Selesai
                                                                </option>
                                                                @foreach ($years as $year)
                                                                    <option
                                                                        value="{{ $year }}"@if ($year == $item->tahun_selesai) selected @endif>
                                                                        {{ $year }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="my-3">
                                                    <label for="deskripsi"
                                                        class="form-label fw-semibold">Deskripsi</label>
                                                    <textarea name="deskripsi_pengalaman" cols="30" rows="10" class="form-control editor">{{ $item->deskripsi }}</textarea>
                                                </div>

                                                <div class="my-1 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-outline-dark">Update</button>
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
                                        <h4 class="fw-bold">Konfirmasi Hapus Pengalaman</h4>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                            aria-label="close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6 class="fw-semibold">Konfirmasi Penghapusan Pengalaman</h6>
                                        <form method="POST" id="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <div class="d-flex justify-content-end">
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
                    <h6 class="fw-bold text-center my-2">Bingung Belum Ada Pengalaman ?, <br> Atau Kebanyakan Pengalaman ?
                        <br>Konseling Aja Dulu
                    </h6>
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
            const modalContainer = document.getElementById('modalList');

            modalContainer.addEventListener('change', function(event) {
                const clickedCheckbox = event.target;

                if (clickedCheckbox.classList.contains('modal-checkbox')) {
                    const modal = clickedCheckbox.closest('.modal');
                    const checkbox = modal.querySelector('.modal-checkbox');
                    const selectInput = modal.querySelectorAll('.end-date');

                    if (clickedCheckbox.checked) {
                        Array.from(selectInput).forEach(selectInput => {
                            selectInput.disabled = true;
                            selectInput.value = selectInput.querySelector('option:first-child')
                                .value;
                        })
                    } else {
                        Array.from(selectInput).forEach(selectInput => {
                            selectInput.disabled = false;
                        })
                    }
                }
            });
        });

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
