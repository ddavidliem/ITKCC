@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="min-vh-50 bg-white rounded p-4">
            <h4 class="fw-bold">Detail Perusahaan</h4>
            <div class="d-flex">
                @if ($employer->logo_perusahaan)
                    <div class="col-2">
                        <img src="{{ asset('logo/' . $employer->logo_perusahaan) }}" class="img-fluid my-3" alt="">
                    </div>
                @endif
                <div class="col-8 mx-4 @if ($employer->logo_perusahaan === null) offset-1 @endif d-flex">
                    <div class="col-4">
                        <div class="my-2">
                            <label for="" class=" form-label">Nama Perusahaan</label>
                            <h6 class="fw-semibold text-capitalize">{{ $employer->nama_perusahaan }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class=" form-label">Website</label>
                            <h6 class="fw-semibold">{{ $employer->website }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label">Bidang Perusahaan</label>
                            <h6 class="fw-semibold">{{ $employer->bidang_perusahaan }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label">Tahun Berdiri</label>
                            <h6 class="fw-semibold">{{ $employer->tahun_berdiri }}</h6>
                        </div>
                    </div>
                    <div class="col-4 mx-2">
                        <div class="my-2">
                            <label for="" class="form-label">Kantor Pusat</label>
                            <h6 class="fw-semibold">{{ $employer->kantor_pusat }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class=" form-label">Kota</label>
                            <h6 class="fw-semibold text-capitalize">{{ $employer->kota }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class=" form-label">Provinsi</label>
                            <h6 class="fw-semibold text-capitalize">{{ $employer->provinsi }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class=" form-label">Alamat</label>
                            <h6 class="fw-semibold text-capitalize">{{ $employer->alamat }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class=" form-label">Kode Pos</label>
                            <h6 class="fw-semibold text-capitalize">{{ $employer->kode_pos }}</h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <h6 class="fw-semibold">Detail Employer</h6>
                        <div class="my-2">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <h6 class="fw-semibold text-capitalize">{{ $employer->nama_lengkap }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label">Nomor Telepon</label>
                            <h6 class="fw-semibold text-capitalize">{{ $employer->nomor_telepon }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label">Alamat Email</label>
                            <h6 class="fw-semibold">{{ $employer->alamat_email }}</h6>
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label">Jabatan</label>
                            <h6 class="fw-semibold">{{ $employer->jabatan }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="d-flex">
                        <button class="btn btn-outline-dark edit-employer-btn mx-2" data-bs-toggle="modal"
                            data-bs-target="#editEmployer">Edit</button>
                        <button class="btn btn-outline-danger delete-employer-btn" data-bs-toggle="modal"
                            data-bs-target="#deleteEmployer">Delete</button>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <h6 class="fw-semibold">Deskripsi Perusahaan</h6>
                <div>
                    <p>{{ $employer->deskripsi_perusahaan }}</p>
                </div>
            </div>

            @if ($employer->status == 'suspended')
                <div class="my-4 alert alert-danger p-2" role="alert">
                    <h5 class="fw-semibold">Akun Perusahaan Telah Di Suspend</h5>
                    <div class="my-2">
                        <h6 class=" text-danger fw-semibold">Alasan Suspend</h6>
                        <p>{{ $employer->suspend_note }}</p>
                        <br>
                        <p>Akun Perusahaan ini Tidak Dapat Melakukan Login dan Seluruh Lowongan Pekerjaan Perusahaan Telah
                            Di Tutup. Beserta Lamaran Kerja pada Lowongan kerja Terkait telah ditolak.</p>
                    </div>
                </div>
            @endif

            <div class="my-4">
                <div class="d-flex my-4">
                    <div class="col-7">
                        <h6 class="fw-semibold mb-2">Total Akumulasi Lowongan Kerja 6 Bulan Terakhir</h6>
                        <canvas id="loker-total-chart"></canvas>
                    </div>
                </div>
                <div class="d-flex justify-content-center my-4">
                    <div class="col-4">
                        <h6 class="fw-semibold mb-2">Presentase Tipe Lowongan Kerja</h6>
                        <canvas id="loker-tipe-chart"></canvas>
                    </div>
                    <div class="col-4 offset-2">
                        <h6 class="fw-semibold mb-2">Presentase Jenis Lowongan Kerja</h6>
                        <canvas id="loker-jenis-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4">
            <div class="p-4 bg-white rounded min-vh-100">
                <div class="d-flex my-3">
                    <div class="col-6">
                        <h4 class="fw-bold">Daftar Lowongan Kerja</h4>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <input type="search" placeholder="Search" class="form-control" id="search">
                    </div>
                </div>
                <div class="max-vh-75 overflow-auto">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr class="position-sticky top-0">
                                <th class="fw-semibold">Nama Pekerjaan</th>
                                <th class="fw-semibold">Jenis Pekerjaan</th>
                                <th class="fw-semibold">Tipe Pekerjaan</th>
                                <th class="fw-semibold">Lokasi Pekerjaan</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employerDetail['loker'] as $item)
                                <tr class="@if ($item->trashed()) table-warning @endif">
                                    <td class="text-capitalize">{{ $item->nama_pekerjaan }}</td>
                                    <td class="text-capitalize">{{ $item->jenis_pekerjaan }}</td>
                                    <td class="text-capitalize">{{ $item->tipe_pekerjaan }}</td>
                                    <td class="text-capitalize">{{ $item->lokasi_pekerjaan }}</td>
                                    <td class="text-capitalize">
                                        @if ($item->trashed())
                                            Deleted by Employer
                                        @else
                                            {{ $item->status }}
                                        @endif
                                    </td>
                                    <td><a href="{{ Route('admin.loker.detail', ['id' => $item->id]) }}"
                                            class="text-decoration-none text-dark fw-semibold">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.employer.modal.delete-employer')
    @include('admin.employer.modal.edit-employer')
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const tipeLoker = @json($tipeLoker);
            const jenisLoker = @json($jenisLoker);
            const totalLoker = @json($totalLoker);

            const tipeLokerDataConfig = {
                labels: tipeLoker.label,
                datasets: [{
                    data: tipeLoker.data,
                }],
            }

            const jenisLokerDataConfig = {
                labels: jenisLoker.label,
                datasets: [{
                    data: jenisLoker.data,
                }]
            }

            const totalLokerDataConfig = {
                labels: totalLoker.labels,
                datasets: [{
                    data: totalLoker.data,
                    label: 'Total Akumulasi Lowongan Kerja 6 Bulan Terakhir'
                }],
            }

            const tipeLokerChart = new Chart(document.getElementById('loker-tipe-chart'), {
                type: 'doughnut',
                data: tipeLokerDataConfig,
            });

            const jenisLokerChart = new Chart(document.getElementById('loker-jenis-chart'), {
                type: 'doughnut',
                data: jenisLokerDataConfig,
            });

            const totalLokerChart = new Chart(document.getElementById('loker-total-chart'), {
                type: 'line',
                data: totalLokerDataConfig,
            })
        });

        $(document).ready(function() {
            $('#search').on('input', function() {
                searchTable();
            });

            function searchTable() {
                const searchQuery = $('#search').val().toLowerCase();
                const $rows = $('tbody tr');
                $rows.show();
                $rows.each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.indexOf(searchQuery) === -1) {
                        $(this).hide();
                    }
                });
            }
        });
    </script>
@endpush
