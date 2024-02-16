@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="d-flex bg-white min-vh-50 rounded p-2">
            <div class="col-5 p-2">
                <div>
                    <h4 class="fw-bold">Approval Akun Perusahaan</h4>
                </div>
                <div class="my-4">
                    <ul class=" list-unstyled list-group list-group-flush">
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Approval Telah Disetujui</h6>
                            <h6 class="col-2">{{ $approval['approved'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Approval Ditolak</h6>
                            <h6 class="col-2">{{ $approval['not_approved'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Total Approval</h6>
                            <h6 class="col-2">{{ $approval['total'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <a href="{{ Route('admin.approval') }}" class="btn btn-outline-dark">Lihat Selengkapnya</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-7 p-4">
                <canvas id="approval-chart" class="img-fluid"></canvas>
            </div>
        </div>

        <div class="d-flex bg-white min-vh-50 rounded p-2 my-4">
            <div class="col-5 p-2">
                <div>
                    <h4 class="fw-bold">Appointment Konseling Karir</h4>
                </div>
                <div class="my-4">
                    <ul class=" list-unstyled list-group list-group-flush">
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Appointment Terbaru Minggu Ini</h6>
                            <h6 class="col-2">{{ $appointment['week'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Total Appointment</h6>
                            <h6 class="col-2">{{ $appointment['total'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Appointment Belum Di Setujui</h6>
                            <h6 class="col-2">{{ $appointment['pending'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Appointment Telah Di Setujui</h6>
                            <h6 class="col-2">{{ $appointment['approved'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Total Appointment Selesai</h6>
                            <h6 class="col-2">{{ $appointment['done'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <a href="{{ Route('admin.appointment') }}" class="btn btn-outline-dark">Lihat Selengkapnya</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-7 p-4">
                <canvas id="appointment-chart" class="img-fluid"></canvas>
            </div>
        </div>

        <div class="d-flex bg-white min-vh-50 rounded p-2 my-4">
            <div class="col-5 p-2">
                <div>
                    <h4 class="fw-bold">Statistik Perusahaan Terdaftar</h4>
                </div>
                <div class="my-4">
                    <ul class=" list-unstyled list-group list-group-flush">
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Perusahaan Terdaftar</h6>
                            <h6 class="col-2">{{ $employer['total'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Perusahaan Terbaru Bulan Ini</h6>
                            <h6 class="col-2">{{ $employer['new'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Perusahaan Belum Melakukan Verifikasi</h6>
                            <h6 class="col-2">{{ $employer['emailNull'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <a href="{{ Route('admin.employer') }}" class="btn btn-outline-dark">Lihat Selengkapnya</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-7 p-4">
                <canvas id="employer-chart" class="img-fluid"></canvas>
            </div>
        </div>

        <div class=" bg-white min-vh-75 rounded p-2 my-4">
            <div class="d-flex">
                <div class="col-5 p-2">
                    <div>
                        <h4 class="fw-bold">Informasi Lowongan Kerja</h4>
                    </div>
                    <div class="my-4">
                        <ul class=" list-unstyled list-group list-group-flush">
                            <li class="list-group-item p-2 my-2 d-flex">
                                <h6 class="fw-semibold col-10">Jumlah Lowongan Kerja Terdaftar</h6>
                                <h6 class="col-2">{{ $loker['total'] }}</h6>
                            </li>
                            <li class="list-group-item p-2 my-2 d-flex">
                                <h6 class="fw-semibold col-10">Jumlah Lowongan Kerja Terbuka</h6>
                                <h6 class="col-2">{{ $loker['open'] }}</h6>
                            </li>
                            <li class="list-group-item p-2 my-2 d-flex">
                                <h6 class="fw-semibold col-10">Jumlah Lowongan Kerja Selesai</h6>
                                <h6 class="col-2">{{ $loker['closed'] }}</h6>
                            </li>
                            <li class="list-group-item p-2 my-2 d-flex">
                                <a href="{{ Route('admin.loker') }}" class="btn btn-outline-dark">Lihat Selengkapnya</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-7 p-4">
                    <canvas id="loker-chart" class="img-fluid"></canvas>
                </div>
            </div>
        </div>

        <div class="d-flex bg-white min-vh-50 rounded p-2 my-4">
            <div class="col-5 p-2">
                <div>
                    <h4 class="fw-bold">Statistik Pengguna Terdaftar</h4>
                </div>
                <div class="my-4">
                    <ul class=" list-unstyled list-group list-group-flush">
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Total Pengguna</h6>
                            <h6 class="col-2">{{ $user['user_total'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Pengguna Baru Bulan Ini</h6>
                            <h6 class="col-2">{{ $user['user_new'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Pengguna Disabilitas</h6>
                            <h6 class="col-2">{{ $user['user_disability'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Pengguna Sudah Membuat Lamaran</h6>
                            <h6 class="col-2">{{ $user['user_application'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Pengguna Mahasiswa ITK</h6>
                            <h6 class="col-2">{{ $user['user_itk'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <h6 class="fw-semibold col-10">Jumlah Pengguna Belum Terverifikasi</h6>
                            <h6 class="col-2">{{ $user['user_notverify'] }}</h6>
                        </li>
                        <li class="list-group-item p-2 my-2 d-flex">
                            <a href="{{ Route('admin.user') }}" class="btn btn-outline-dark">Lihat Selengkapnya</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-7 p-4">
                <canvas id="user-chart" class="img-fluid"></canvas>
            </div>
        </div>
    @endsection

    @push('script')
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {
                const userData = @json($userData);
                const employerData = @json($employerData);
                const lokerData = @json($lokerData);
                const approvalData = @json($approvalData);
                const appointmentData = @json($appointmentData);

                const userDataconfig = {
                    labels: userData.labels,
                    datasets: [{
                        data: userData.data,
                        label: 'Total Pencari Kerja Terdaftar 6 Bulan Terakhir',
                    }],
                };

                const employerDataconfig = {
                    labels: employerData.labels,
                    datasets: [{
                        data: employerData.data,
                        label: 'Total Perusahaan Terdaftar 6 Bulan Terakhir'
                    }],
                };

                const lokerDataconfig = {
                    labels: lokerData.labels,
                    datasets: [{
                        data: lokerData.data,
                        label: 'Total Lowongan Kerja Terdaftar 6 Bulan Terakhir'
                    }]
                };

                const appointmentDataconfig = {
                    labels: appointmentData.labels,
                    datasets: [{
                        data: appointmentData.data,
                        label: 'Total Appointment Konseling Karir 6 Bulan Terakhir',
                    }],
                };

                const approvalDataconfig = {
                    labels: approvalData.labels,
                    datasets: [{
                        data: approvalData.data,
                        label: ' Total Approval 6 Bulan Terakhir',
                    }],
                };

                const approvalchart = new Chart(document.getElementById('approval-chart'), {
                    type: 'line',
                    data: approvalDataconfig,
                });

                const appointmentchart = new Chart(document.getElementById('appointment-chart'), {
                    type: 'line',
                    data: appointmentDataconfig,
                });

                const lokerchart = new Chart(document.getElementById('loker-chart'), {
                    type: 'line',
                    data: lokerDataconfig,
                });

                const employerchart = new Chart(document.getElementById('employer-chart'), {
                    type: 'line',
                    data: employerDataconfig,
                });

                const userchart = new Chart(document.getElementById('user-chart'), {
                    type: 'line',
                    data: userDataconfig,
                });
            });
        </script>
    @endpush
