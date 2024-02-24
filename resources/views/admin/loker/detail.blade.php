@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="p-4 min-vh-50 bg-white rounded">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="fw-semibold">Detail Lowongan Pekerjaan</h5>
                </div>
                <div>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editLoker">Edit Loker</button>
                    <button class="btn btn-outline-danger mx-2" data-bs-toggle="modal" data-bs-target="#deleteLoker">Delete
                        Loker</button>
                </div>
            </div>
            <div class="my-4 d-flex">
                <div class="col-1 p-2">
                    <img src="{{ asset('logo/' . $loker->employer->logo_perusahaan) }}" class="img-fluid" alt="">
                </div>
                <div class="col-7 px-4">
                    <h4 class="fw-semibold text-capialitze">{{ $loker->nama_pekerjaan }}</h4>
                    <ul class="list-unstyled">
                        <li class="fw-semibold text-capitalize">{{ $loker->employer->nama_perusahaan }}</li>
                        <li>{{ $loker->jenis_pekerjaan }} | {{ $loker->tipe_pekerjaan }}</li>
                        <li>{{ $loker->lokasi_pekerjaan }}</li>
                        <li>Status: {{ $loker->status }}</li>
                        <li>Deadline: {{ $loker->deadline->format('d-m-Y') }}</li>
                        @if (!empty($loker->deskripsi_pekerjaan))
                            <li><a href="" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#loker-description"aria-expanded="false"
                                    class="text-decoration-none text-muted">Deskripsi Pekerjaan</a>
                            </li>
                            <li>
                                <div class="collapse" id="loker-description">
                                    <p>{!! nl2br($loker->deskripsi_pekerjaan) !!}</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-4 p-2">
                    <h6 class="fw-semibold">Poster Lowongan Kerja</h6>
                    <img src="{{ asset('poster/' . $loker->poster) }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
        <div class="my-4 bg-white rounded min-vh-50 p-4 d-flex justify-content-evenly">
            <div class="col-4">
                <h6 class="fw-semibold">Statistik Status Pelamar</h6>
                <canvas id="status-applicant"></canvas>
            </div>
            <div class="col-4 offset-1">
                <h6 class="fw-semibold">Statistik Pelamar</h6>
                <canvas id="category-applicant"></canvas>
            </div>
        </div>

        <div class="my-4 d-flex">
            <div class="col-4 px-2">
                <div class="bg-white rounded min-vh-100 max-vh-100 overflow-auto p-4">
                    <div class="mb-4">
                        <h5 class="fw-semibold">Daftar Pelamar</h5>
                        <div class="my-4">
                            <input type="text" role="search" id="search" class="form-control"
                                placeholder="Search Loker">
                        </div>
                    </div>
                    <table class="table table-hover table-borderless" role="tablist">
                        <thead class="table-light">
                            <tr class="position-0 sticky-top">
                                <td class="fw-semibold">Daftar Pelamar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loker->applicants()->with('user')->orderBy('created_at', 'DESC')->get() as $item)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0)" type="button" role="tab"
                                            class="text-decoration-none text-dark d-flex justify-content-between p-1"
                                            data-bs-target="#tab-{{ $item->id }}" data-bs-toggle="tab">
                                            <div class="col-8">
                                                <h6 class="fw-semibold my-2 text-capitalize">
                                                    {{ $item->nama_lengkap }}</h6>
                                                <ul class="list-unstyled">
                                                    <li class="">{{ $item->user->alamat_email }}</li>
                                                    <li class="text-capitalize">{{ $item->user->nomor_telepon }}</li>
                                                </ul>
                                            </div>
                                            <div class="col-4 justify-content-end">
                                                <h6 class="text-capitalize fw-semibold">{{ $item->status }}</h6>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-8 px-2">
                <div class="bg-white rounded min-vh-100 max-vh-100 overflow-auto p-4">
                    <div class="tab-content" id="tab-content">
                        @foreach ($loker->applicants as $item)
                            <div id="tab-{{ $item->id }}" class="p-2 tab-pane" role="tabpanel">
                                <div class="bg-white p-44 min-vh-10 mb-3">
                                    <div class="d-flex mb-4">
                                        <h3 class="fw-bold col-10">Informasi Pelamar</h3>
                                        <div class="col-2 d-flex justify-content-end">
                                            <a href="{{ Route('admin.user.detail', ['id' => $item->user->id]) }}"
                                                class="btn btn-outline-dark">Detail</a>
                                            {{-- <button class="btn btn-outline-dark status-button mx-2" data-bs-toggle="modal"
                                                data-bs-target="#responseModal" data-url="">Status</button> --}}
                                            <button class="btn btn-outline-danger delete-button mx-2" data-bs-toggle="modal"
                                                data-bs-target="#deleteApprovalModal"
                                                data-url="{{ Route('admin.application.delete', ['id' => $item->id]) }}">Delete</button>
                                        </div>
                                    </div>
                                    <div class="my-2">
                                        <div class="d-flex">
                                            <div class="col-2">
                                                <img src="{{ asset('profile/' . $item->user->profile) }}" class="img-fluid"
                                                    alt="">
                                            </div>
                                            <div class="px-3">
                                                <h5 class="text-capitalize fw-semibold mb-2">{{ $item->nama_lengkap }}</h5>
                                                <div class="d-flex">
                                                    <div class="col-6">
                                                        <div class="my-1">
                                                            <label for="" class="form-label fw-semibold">Alamat
                                                                Email</label>
                                                            <h6 class="">{{ $item->user->alamat_email }}</h6>
                                                        </div>
                                                        <div class="my-1">
                                                            <label for="" class="form-label fw-semibold">Nomor
                                                                Telepon</label>
                                                            <h6 class="">{{ $item->user->nomor_telepon }}</h6>
                                                        </div>
                                                        @if ($item->nim)
                                                            <div class="my-1">
                                                                <label for=""
                                                                    class="form-label fw-semibold">NIM</label>
                                                                <h6 class="">{{ $item->nim }}</h6>
                                                            </div>
                                                            <div class="my-1">
                                                                <label for=""
                                                                    class="form-label fw-semibold">Program
                                                                    Studi</label>
                                                                <h6 class="">{{ $item->program_studi }}</h6>
                                                            </div>
                                                        @endif
                                                        <div class="my-1">
                                                            <label for=""
                                                                class="form-label fw-semibold">Agama</label>
                                                            <h6 class="">{{ $item->agama }}</h6>
                                                        </div>
                                                        <div class="my-1">
                                                            <label for=""
                                                                class="form-label fw-semibold">Pendidikan
                                                                Tertinggi</label>
                                                            <h6 class="">{{ $item->pendidikan_tertinggi }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="my-1">
                                                            <label for="" class="form-label fw-semibold">Tempat
                                                                dan
                                                                Tanggal Lahir</label>
                                                            <h6>{{ $item->tempat_lahir }},{{ $item->tanggal_lahir }}
                                                            </h6>
                                                        </div>
                                                        <div class="my-1">
                                                            <label for=""
                                                                class="form-label fw-semibold">Kewarganegaraan</label>
                                                            <h6>{{ $item->kewarganegaraan }}</h6>
                                                        </div>
                                                        <div class="my-1">
                                                            <label for=""
                                                                class="fw-semibold form-label">Status</label>
                                                            <h6>{{ $item->status_perkawinan }}</h6>
                                                        </div>
                                                        <div class="my-1">
                                                            <label for=""
                                                                class="form-label fw-semibold">Alamat</label>
                                                            <h6>{{ $item->alamat }}</h6>
                                                        </div>
                                                        <div class="my-1">
                                                            <label for=""
                                                                class="form-label fw-semibold">Kota</label>
                                                            <h6>{{ $item->kota }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Sertifikat Pelamar</h5>
                                        <div class="my-2 min-vh-25 max-vh-50 overflow-auto">
                                            <table class="table table-hover table-borderless">
                                                <thead class="table-light">
                                                    <tr class="position-sticky top-0">
                                                        <th class="fw-semibold">Daftar Sertifikat Pelamar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item->user->sertifikat as $sertifikat)
                                                        <tr>
                                                            <td>
                                                                <h6 class="fw-semibold">{{ $sertifikat->title }}</h6>
                                                                <ul class="list-unstyled">
                                                                    <li class="fw-semibold">{{ $sertifikat->organisasi }}
                                                                    </li>
                                                                    <li class="fw-semibold">
                                                                        {{ $sertifikat->tanggal_terbit }} @if ($sertifikat->tanggal_berakhir)
                                                                            | {{ $sertifikat->tanggal_berakhir }}
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Pendidikan Pelamar</h5>
                                        <div class="my-2 min-vh-25 max-vh-50 overflow-auto">
                                            <table class="table table-hover table-borderless">
                                                <thead class="table-light">
                                                    <tr class="position-sticky top-0">
                                                        <th class="fw-semibold">Daftar Pendidikan Pelamar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item->user->pendidikan as $pendidikan)
                                                        <tr>
                                                            <td>
                                                                <h6 class="fw-semibold">{{ $pendidikan->nama_sekolah }}
                                                                </h6>
                                                                <ul class="list-unstyled">
                                                                    <li class="fw-semibold">
                                                                        {{ $pendidikan->tingkat_pendidikan }} |
                                                                        {{ $pendidikan->bidang_studi }} |
                                                                        {{ $pendidikan->tahun_lulus }}
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Pengalaman Kerja Pelamar</h5>
                                        <div class="my-2 min-vh-25 max-vh-50 overflow-auto">
                                            <table class="table table-hover table-borderless">
                                                <thead class="table-light">
                                                    <tr class="position-sticky top-0">
                                                        <th class="fw-semibold">Daftar Pengalaman Kerja Pelamar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item->user->pengalaman as $pengalaman)
                                                        <tr>
                                                            <td>
                                                                <h6 class="fw-semibold">{{ $pengalaman->title }}</h6>
                                                                <ul class="list-unstyled">
                                                                    <li class="fw-semibold">{{ $pengalaman->organisasi }}
                                                                    </li>
                                                                    <li>{{ $pengalaman->lokasi_pekerjaan }}</li>
                                                                    <li class="fw-semibold">
                                                                        {{ $pengalaman->tanggal_mulai }} @if ($pengalaman->tanggal_selesai)
                                                                            | {{ $pengalaman->tanggal_selesai }}
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Resume Pelamar</h5>
                                        <div class="">
                                            <iframe src="{{ asset('resume/' . $item->user->resume) }}" frameborder="0"
                                                class="my-2 w-100 min-vh-100"></iframe>
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

    @if ($loker->poster)
        @include('admin.loker.modal.poster')
    @endif
    @include('admin.loker.modal.edit')
    @include('admin.loker.modal.delete')
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const status = @json($status);
            const category = @json($category);

            const statusDataConfig = {
                labels: status.labels,
                datasets: [{
                    data: status.data,
                }],
            };

            const categoryDataConfig = {
                labels: ['User ITK', 'User'],
                datasets: [{
                    data: [category.itk, category.not_itk],
                }],
            };

            const categoryChart = new Chart(document.getElementById('category-applicant'), {
                type: 'doughnut',
                data: categoryDataConfig,
            });

            const statusChart = new Chart(document.getElementById('status-applicant'), {
                type: 'doughnut',
                data: statusDataConfig,
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
