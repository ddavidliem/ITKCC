@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="p-4 min-vh-75 bg-white rounded">
            <h4 class="fw-bold">Statistik Data Perusahaan</h4>
            <div class="my-2 d-flex">
                <div class="my-4 col-5">
                    <ul class="list-unstyled list-group list-group-flush">
                        <li class="list-group-item d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Perusahaan Terdaftar dan Terverifikasi</h6>
                            <h6 class="col-2">{{ $employer['total'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Perusahaan Tidak Terverifikasi</h6>
                            <h6 class="col-2">{{ $employer['null'] }}</h6>
                        </li>
                    </ul>
                </div>
                <div class="my-4 col-6 offset-1">
                    <h6 class="fw-semibold mb-2">Total Employer Terbaru 6 Bulan Terakhir</h6>
                    <canvas id="new-employer-chart"></canvas>
                </div>
            </div>
            <div class="my-4 d-flex">
                <div class="col-7">
                    <h6 class="fw-semibold mb-2">Total Perusahaan Terdaftar 6 Bulan Terakhir</h6>
                    <canvas id="total-employer-chart"></canvas>
                </div>
                <div class="col-4 offset-1">
                    <h6 class="fw-semibold mb-2">Presentase Verifikasi Perusahaan</h6>
                    <canvas id="verification-employer-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="my-4 p-4 min-vh-100 rounded bg-white">
            <div class="my-1 d-flex justify-content-between">
                <h6 class="fw-semibold">Daftar Perusahaan</h6>
                <div class="col-5">
                    <input type="text" class="form-control" id="search" placeholder="Search Perusahaan">
                </div>
            </div>
            <div class="my-4">
                <div class=" max-vh-75 overflow-auto">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr class=" position-sticky top-0">
                                <th class="fw-semibold">Nama Perusahaan</th>
                                <th class="fw-semibold">Kota</th>
                                <th class="fw-semibold">Bidang Perusahaan</th>
                                <th class="fw-semibold">Tahun Berdiri</th>
                                <th class="fw-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($employer['all'] as $item)
                                <tr>
                                    <td class="text-capitalize ">{{ $item->nama_perusahaan }}</td>
                                    <td class="text-capitalize ">{{ $item->kota }}</td>
                                    <td class="text-capitalize ">{{ $item->bidang_perusahaan }}</td>
                                    <td class="text-capitalize ">{{ $item->tahun_berdiri }}</td>
                                    <td class=""><a href="{{ Route('admin.employer.detail', ['id' => $item->id]) }}"
                                            class="text-dark text-decoration-none fw-semibold">Detail</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const employerTotal = @json($employerTotal);
            const employerNew = @json($employerNew);
            const employer = @json($employer);
            const employerNewDataConfig = {
                labels: employerNew.labels,
                datasets: [{
                    data: employerNew.data,
                    label: 'Total Perusahaan Baru 6 Bulan Terakhir'
                }],
            }

            const employerTotalDataConfig = {
                labels: employerTotal.labels,
                datasets: [{
                    data: employerTotal.data,
                    label: 'Total Perusahaan Terdaftar 6 Bulan Terakhir'
                }]
            };

            const employerVerificateDataConfig = {
                labels: ['Perusahaan Terverifikasi', 'Perusahaan Belum Terverifikasi'],
                datasets: [{
                    data: [employer['total'], employer['null']]
                }],
            }

            const employerTotalChart = new Chart(document.getElementById('total-employer-chart'), {
                type: 'line',
                data: employerTotalDataConfig,
            });

            const employerNewChart = new Chart(document.getElementById('new-employer-chart'), {
                type: 'line',
                data: employerNewDataConfig,
            });

            const employerRatioChart = new Chart(document.getElementById('verification-employer-chart'), {
                type: 'doughnut',
                data: employerVerificateDataConfig,
            });

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
