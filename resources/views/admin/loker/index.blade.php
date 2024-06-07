@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="bg-white rounded p-4 min-vh-50">
            <div class="d-flex">
                <div class="col-5">
                    <h4 class="fw-semibold my-4">Daftar Lowongan Pekerjaan</h4>
                    <ul class="list-unstyled list-group list-group-flush">
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Total Lowongan Pekerjaan</h6>
                            <h6 class="col-2 fw-semibold">{{ $loker['total'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Total Lowongan Pekerjaan Terbaru Bulan Ini</h6>
                            <h6 class="col-2 fw-semibold">{{ $loker['new'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Total Lowongan Pekerjaan Terbuka</h6>
                            <h6 class="col-2 fw-semibold">{{ $loker['open'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Total Lowongan Pekerjaan Selesai</h6>
                            <h6 class="col-2 fw-semibold">{{ $loker['closed'] }}</h6>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="my-4 d-flex justify-content-evenly">
                <div class="col-6">
                    <h6 class="fw-semibold">Total Lowongan Pekerjaan 6 Bulan Terakhir</h6>
                    <div class="my-1 p-4">
                        <canvas id="total-loker-chart"></canvas>
                    </div>
                </div>
                <div class="col-6">
                    <h6 class="fw-semibold">Total Lowongan Pekerjaan Terbaru 6 Bulan Terakhir</h6>
                    <div class="my-1 p-4">
                        <canvas id="new-loker-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 bg-white rounded p-4 min-vh-75">
            <h5 class="fw-semibold">Statistik Lowongan Pekerjaan</h5>
            <div class="my-4 d-flex justify-content-evenly">
                <div class="col-4">
                    <h6 class="fw-semibold">Presentase Jenis Pekerjaan</h6>
                    <div class="my-2">
                        <canvas id="jenis-loker-chart"></canvas>
                    </div>
                </div>
                <div class="col-4">
                    <h6 class="fw-semibold">Presentase Tipe Pekerjaan</h6>
                    <div class="my-2">
                        <canvas id="tipe-loker-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-4 bg-white rounded p-4 min-vh-100">
            <div class="my-1 d-flex justify-content-between">
                <h6 class="fw-semibold">Daftar Lowongan Pekerjaan</h6>
                <div class="col-5">
                    <input type="text" class="form-control" id="search" placeholder="Search Lowongan Pekerjaan">
                </div>
            </div>
            <div class="my-4">
                <div class=" max-vh-75 overflow-auto">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr class=" position-sticky top-0">
                                <th class="fw-semibold">Nama Lowongan Pekerjaan</th>
                                <th class="fw-semibold">Nama Perusahaan</th>
                                <th class="fw-semibold">Jenis Pekerjaan</th>
                                <th class="fw-semibold">Tipe Pekerjaan</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($loker['all'] as $item)
                                <tr
                                    class="@if ($item->trashed()) table-warning @endif @if ($item->status == 'Suspended') table-danger @endif">
                                    <td class="text-capitalize ">{{ $item->nama_pekerjaan }}</td>
                                    <td class="text-capitalize ">{{ $item->employer->nama_perusahaan }}</td>
                                    <td class="text-capitalize ">{{ $item->jenis_pekerjaan }}</td>
                                    <td class="text-capitalize ">{{ $item->tipe_pekerjaan }}</td>
                                    <td class="text-capitalize ">
                                        @if ($item->trashed())
                                            Deleted By Employer
                                        @else
                                            {{ $item->status }}
                                        @endif
                                    </td>
                                    <td class=""><a href="{{ Route('admin.loker.detail', ['id' => $item->id]) }}"
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
            const totalLoker = @json($lokerTotal);
            const newLoker = @json($lokerNew);
            const jenisLoker = @json($jenisLokerChart);
            const tipeLoker = @json($tipeLokerChart);

            const totalLokerDataConfig = {
                labels: totalLoker.labels,
                datasets: [{
                    data: totalLoker.data,
                    label: 'Total Lowongan Pekerjaan Terdaftar 6 Bulan Terakhir'
                }],
            };

            const jenisLokerDataConfig = {
                labels: jenisLoker.label,
                datasets: [{
                    data: jenisLoker.data,
                }],
            };

            const newLokerDataConfig = {
                labels: newLoker.labels,
                datasets: [{
                    label: 'Total Lowongan Pekerjaan Terbaru 6 Bulan Terakhir',
                    data: newLoker.data,
                }]
            }

            const tipeLokerDataConfig = {
                labels: tipeLoker.label,
                datasets: [{
                    data: tipeLoker.data,
                }],
            }

            const totalLokerChart = new Chart(document.getElementById('total-loker-chart'), {
                type: 'line',
                data: totalLokerDataConfig,
            });

            const jenisLokerChart = new Chart(document.getElementById('jenis-loker-chart'), {
                type: 'doughnut',
                data: jenisLokerDataConfig,
            });

            const tipeLokerChart = new Chart(document.getElementById('tipe-loker-chart'), {
                type: 'doughnut',
                data: tipeLokerDataConfig,
            });

            const newLokerChart = new Chart(document.getElementById('new-loker-chart'), {
                type: 'line',
                data: newLokerDataConfig,
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
