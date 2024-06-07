@extends('layouts.admin')

@section('content')
    <div class="p-4">

        <div class="bg-white rounded p-4  min-vh-75 mb-4">
            <div class="d-flex">
                <div class="col-5">
                    <h4 class="fw-bold">Approval Permohonan Akun Perusahaan</h4>
                    <ul class="list-unstyled list-group list-group-flush">
                        <li class="list-group-item d-flex my-1">
                            <h6 class="col-8 fw-semibold">Jumlah Total Approval Masuk Bulan Ini</h6>
                            <h6 class="col-2">{{ $approval['new'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-8 fw-semibold">Jumlah Total Approval</h6>
                            <h6 class="col-2">{{ $approval['total'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-8 fw-semibold">Jumlah Approval Belum Di Proses</h6>
                            <h6 class="col-2">{{ $approval['pending'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-8 fw-semibold">Jumlah Approval Di Setujui</h6>
                            <h6 class="col-2">{{ $approval['approved'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-8 fw-semibold">Jumlah Approval Tidak Di Setujui</h6>
                            <h6 class="col-2">{{ $approval['not_approved'] }}</h6>
                        </li>
                    </ul>
                </div>
                <div class="col-5 offset-1">
                    <h6 class="fw-semibold">Total Approval Baru Setiap Bulan</h6>
                    <canvas id="new-approval-chart" class="img-fluid"></canvas>
                </div>
            </div>
            <div class="d-flex my-4">
                <div class="col-7 mx-4">
                    <h6 class="fw-semibold">Total Approval 6 Bulan Terakhir</h6>
                    <canvas id="approval-page-chart" class="img-fluid"></canvas>
                </div>
                <div class="col-4">
                    <h6 class="fw-semibold">Presentase Status Approval Terdaftar</h6>
                    <canvas id="approval-status-chart" class="img-fluid"></canvas>
                </div>
            </div>
        </div>

        <div class="my-2 d-flex">
            <div class="col-4">
                <div class="p-4 bg-white rounded min-vh-100 max-vh-100 overflow-auto">
                    <div class="d-flex">
                        <input type="text" class="form-control" id="search" placeholder="Search Approval">
                    </div>
                    <div class="my-4 max-vh-75 overflow-auto">
                        <table class="table table-hover table-borderless" role="tablist" id="tablist">
                            <thead class="table-light">
                                <tr class="position-sticky top-0">
                                    <th class="fw-semibold">Daftar Approval Akun Perusahaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all as $item)
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0)" type="button" role="tab"
                                                class="text-decoration-none text-dark d-flex p-2"
                                                aria-controls="{{ $item->id }}"
                                                data-bs-target="#tab-{{ $item->id }}" data-bs-toggle="tab">
                                                <div class="col-10">
                                                    <h6 class="fw-semibold my-2 text-capitalize">
                                                        {{ $item->nama_perusahaan }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li class="text-capitalize">{{ $item->nama_lengkap }}</li>
                                                        <li class="text-capitalize">{{ $item->jabatan }}</li>
                                                        <li class="text-capitalize">ID Approval: <br>
                                                            <span>{{ $item->id }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-2">
                                                    <h6 class="text-capitalize fw-semibold">{{ $item->status }}</h6>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            <div class="col-8 mx-2">
                <div class="p-4 bg-white rounded min-vh-100 max-vh-100 overflow-auto">
                    <div class="tab-content" id="tab-content">
                        @foreach ($all as $item)
                            <div id="tab-{{ $item->id }}" class="p-2 tab-pane" role="tabpanel">
                                <div class="bg-white p-44 min-vh-10 mb-3">
                                    <div class="d-flex mb-4">
                                        <h3 class="fw-bold col-10">Detail Permohonan</h3>
                                        <div class="col-2 d-flex justify-content-end">
                                            <button class="btn btn-outline-dark status-button mx-2" data-bs-toggle="modal"
                                                data-bs-target="#approvalModal"
                                                data-url="{{ Route('admin.approval.update', ['id' => $item->id]) }}"
                                                data-content="{{ $item->nama_perusahaan }}"
                                                @if ($item->status == 'accepted') disabled @endif>Status</button>
                                            <button class="btn btn-outline-danger delete-button" data-bs-toggle="modal"
                                                data-bs-target="#deleteApprovalModal"
                                                data-url="{{ Route('admin.approval.delete', ['id' => $item->id]) }}"
                                                data-content="{{ $item->nama_perusahaan }}">Delete</button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="">
                                            <div class="mb-4">
                                                <h6>Nomor Approval : <span class="fw-semibold">{{ $item->id }}</span>
                                                </h6>
                                                <h6>Tanggal Permohonan : <span
                                                        class="fw-semibold">{{ $item->created_at }}</span></h6>
                                                @if ($item->status === 'approved')
                                                    <h6>Approved : <span class="fw-semibold">{{ $item->updated_at }}</span>
                                                    </h6>
                                                @elseif($item->status === 'not approved')
                                                    <h6>Not Approved : <span
                                                            class="fw-semibold">{{ $item->updated_at }}</span></h6>
                                                @elseif($item->status === 'pending')
                                                    <h6>Status : <span
                                                            class="fw-semibold text-capitalize">{{ $item->status }}</span>
                                                    </h6>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Informasi Perusahaan</h5>
                                        <div class="d-flex">
                                            <div class="col-5 mx-2">
                                                <div class="my-1">
                                                    <label for="" class="form-label">Nama Perusahaan</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->nama_perusahaan }}
                                                    </h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Alamat</label>
                                                    <h6 class="fw-semibold">{{ $item->alamat }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Provinsi</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->provinsi }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Bidang perusahaan</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->bidang_perusahaan }}
                                                    </h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Kantor Pusat</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->kantor_pusat }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-5 mx-2">
                                                <div class="my-1">
                                                    <label for="" class="form-label">Kota</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->kota }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Kode Pos</label>
                                                    <h6 class="fw-semibold">{{ $item->kode_pos }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Website</label>
                                                    <h6 class="fw-semibold">{{ $item->website }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Tahun Berdiri</label>
                                                    <h6 class="fw-semibold">{{ $item->tahun_berdiri }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Informasi Employer</h5>
                                        <div class="d-flex">
                                            <div class="col-5 mx-2">
                                                <div class="my-1">
                                                    <label for="" class="form-label">Nama Lengkap</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->nama_lengkap }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Jabatan</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->jabatan }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-5 mx-2">
                                                <div class="my-1">
                                                    <label for="" class="form-label">Nomor Telepon</label>
                                                    <h6 class="fw-semibold">{{ $item->nomor_telepon }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Alamat Email</label>
                                                    <h6 class="fw-semibold">{{ $item->alamat_email }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Formulir Permohonan</h5>
                                        <div class="">
                                            <iframe src="{{ asset('formulir/' . $item->formulir) }}" frameborder="0"
                                                class="my-4 w-100 min-vh-100"></iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.approval.modal.approval')
    @include('admin.approval.modal.delete-approval')
@endsection

@push('script')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function() {
            const statusBtn = document.querySelectorAll('.status-button');
            const statusForm = document.getElementById('statusForm');
            const approvalRespon = document.getElementById('approvalRespon');
            Array.from(statusBtn).forEach(status => {
                status.addEventListener('click', function() {
                    statusForm.setAttribute('action', status.getAttribute('data-url'));
                    approvalRespon.innerHTML = status.getAttribute('data-content');
                });
            });

            const deleteBtn = document.querySelectorAll('.delete-button');
            const deleteForm = document.getElementById('deleteForm');
            const approvalDelete = document.getElementById('approvalDelete')
            Array.from(deleteBtn).forEach(dltBtn => {
                dltBtn.addEventListener('click', function() {
                    deleteForm.setAttribute('action', dltBtn.getAttribute('data-url'));
                    approvalDelete.innerHTML = dltBtn.getAttribute('data-content');
                });
            });

            const newapproval = @json($newApprovalChart);
            const approvalData = @json($approvalDataChart);

            const newApprovalDataConfig = {
                labels: newapproval.labels,
                datasets: [{
                    label: 'Approval Terbaru Setiap Bulan',
                    data: newapproval.data
                }],
            }


            const approvalDataconfig = {
                labels: approvalData.labels,
                datasets: [{
                    label: 'Total Approval',
                    data: approvalData.data,
                }],
            };
            const approvalStatusConfig = {
                labels: ['Not Approved', 'Approved', 'Pending'],
                datasets: [{
                    label: 'Status Approval',
                    data: [
                        @json($approval['not_approved']),
                        @json($approval['approved']),
                        @json($approval['pending']),
                    ],
                }],
            };

            const newapprovalChart = new Chart(document.getElementById('new-approval-chart'), {
                type: 'line',
                data: newApprovalDataConfig,
            });

            const approvalchart = new Chart(document.getElementById('approval-page-chart'), {
                type: 'line',
                data: approvalDataconfig,
            });
            const approvalStatus = new Chart(document.getElementById('approval-status-chart'), {
                type: 'doughnut',
                data: approvalStatusConfig,
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
