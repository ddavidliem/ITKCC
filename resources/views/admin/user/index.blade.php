@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="bg-white rounde p-4 min-vh-75">
            <div class="d-flex">
                <div class="col-5">
                    <h4 class="fw-semibold">Statistik Data Pengguna</h4>
                    <ul class="list-unstyled list-group list-group-flush">
                        <li class="list-group-item d-flex my-1">
                            <h6 class="col-10 fw-semibold">Jumlah Total Pengguna</h6>
                            <h6 class="col-2">{{ $user['user_total'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Pengguna Baru Bulan Ini</h6>
                            <h6 class="col-2">{{ $user['user_new'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Pengguna Belum Terverifikasi</h6>
                            <h6 class="col-2">{{ $user['user_nullApplication'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Pengguna Disabilitas</h6>
                            <h6 class="col-2">{{ $user['user_disability'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Pengguna Dengan Lamaran</h6>
                            <h6 class="col-2">{{ $user['user_application'] }}</h6>
                        </li>
                        <li class="list-group-item d-flex">
                            <h6 class="col-10 fw-semibold">Jumlah Pengguna Mahasiswa & Alumni ITK</h6>
                            <h6 class="col-2">{{ $user['user_itk'] }}</h6>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-evenly my-4">
                <div class="col-5">
                    <h6 class="fw-semibold">Total Akumulasi Pengguna 6 Bulan Terakhir</h6>
                    <canvas class="img-fluid" id="total-user-chart"></canvas>
                </div>
                <div class="col-5">
                    <h6 class="fw-semibold">Total Pengguna Terbaru 6 Bulan Terakhir</h6>
                    <canvas class="img-fluid" id="new-user-chart"></canvas>
                </div>
            </div>
            <div class="d-flex justify-content-evenly my-4">
                <div class="col-4">
                    <h6 class="fw-semibold">Presentase Pengguna</h6>
                    <canvas class="img-fluid" id="category-user-chart"></canvas>
                </div>
                <div class="col-4">
                    <h6 class="fw-semibold">Presentase Program Studi</h6>
                    <canvas class="img-fluid" id="prodi-user-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="my-4 min-vh-50 bg-white rounded p-4">
            <div class="d-flex justify-content-between">
                <h5 class="fw-semibold">Daftar Program Studi</h5>
                <div>
                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#newProdi">Tambah Program
                        Studi</button>
                </div>
            </div>
            <div class="my-4 max-vh-50 overflow-auto">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr class=" position-sticky top-0">
                            <th>Program Studi</th>
                            <th>Jurusan</th>
                            <th>Fakultas</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user['prodi'] as $item)
                            <tr>
                                <td>{{ $item->program_studi }}</td>
                                <td>{{ $item->jurusan }}</td>
                                <td>{{ $item->fakultas }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editProdi"
                                        data-id="{{ Route('admin.prodi.detail', ['id' => $item->id]) }}"
                                        data-url="{{ Route('admin.prodi.update', ['id' => $item->id]) }}"
                                        id="editProdiBtn">Edit</button>
                                    <button class="mx-2 btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteProdi"
                                        data-url="{{ Route('admin.prodi.delete', ['id' => $item->id]) }}"
                                        id="deleteProdiBtn">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="my-4 min-vh-75 p-4 bg-white rounded">
            <div class="d-flex justify-content-between">
                <h5 class="fw-semibold">Daftar Pengguna Terdaftar</h5>
                <div class="mx-4 col-3">
                    <input type="text" role="search" id="search" class="form-control" placeholder="Search User">
                </div>
            </div>
            <div class="my-4 min-vh-75 max-vh-100 overflow-auto">
                <table class="table table-hover" id="user-table">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <th>Nama</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat Email</th>
                            <th>Program Studi</th>
                            <th>Status</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                    <tbody class="max-vh-100 overflow-auto">
                        @foreach ($user['all'] as $item)
                            <tr class="{{ $item->status === 'suspended' ? 'table-danger' : '' }}">
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->nomor_telepon }}</td>
                                <td>{{ $item->alamat_email }}</td>
                                <td>{{ $item->program_studi }}</td>
                                <td>{{ $item->status }}</td>
                                <td><a href="{{ Route('admin.user.detail', ['id' => $item->id]) }}"
                                        class="text-decoration-none text-dark fw-semibold">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.user.modal.new-prodi')
    @include('admin.user.modal.edit-prodi')
    @include('admin.user.modal.delete-prodi')
@endsection

@push('script')
    <script type="module">
        const userData = @json($userData);
        const userNew = @json($userNew);
        const userITK = @json($user['user_itk']);
        const user = @json($user['user']);
        const userProdi = @json($userProdi);

        const userProdiDataConfig = {
            labels: userProdi.labels,
            datasets: [{
                data: userProdi.data,
            }],
        }

        const userCateogoryDataConfig = {
            labels: ['Mahasiswa/Alumni ITK', 'Pengguna Biasa'],
            datasets: [{
                data: [userITK, user],
            }],
        }

        const userNewDataConfig = {
            labels: userNew.labels,
            datasets: [{
                data: userNew.data,
                label: 'Total Pengguna Terbaru 6 Bulan Terakhir',
            }],
        };

        const userDataConfig = {
            labels: userData.labels,
            datasets: [{
                data: userData.data,
                label: 'Total Akumulasi Pengguna 6 Bulan Terakhir'
            }],
        };

        const userProdiChart = new Chart(document.getElementById('prodi-user-chart'), {
            type: 'doughnut',
            data: userProdiDataConfig,
        });

        const userDataChart = new Chart(document.getElementById('total-user-chart'), {
            type: 'line',
            data: userDataConfig
        });

        const userNewDataChart = new Chart(document.getElementById('new-user-chart'), {
            type: 'line',
            data: userNewDataConfig,
        });

        const userCategoryChart = new Chart(document.getElementById('category-user-chart'), {
            type: 'doughnut',
            data: userCateogoryDataConfig,
        });

        $(document).ready(function() {
            $('#search').on('input', function() {
                searchTable();
            });

            function searchTable() {
                const searchQuery = $('#search').val().toLowerCase();
                const $rows = $('#user-table tbody tr');
                $rows.show();
                $rows.each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.indexOf(searchQuery) === -1) {
                        $(this).hide();
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.querySelectorAll('#editProdiBtn');
            const editForm = document.getElementById('editProdiForm');
            const deleteBtn = document.querySelectorAll('#deleteProdiBtn');
            const deleteForm = document.getElementById('deleteProdiForm')
            Array.from(editBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    editForm.setAttribute('action', btn.getAttribute('data-url'));
                    $.ajax({
                        type: "Get",
                        url: this.getAttribute('data-id'),
                        success: function(response) {
                            editForm.querySelector('#prodi-input').value = response
                                .program_studi;
                            editForm.querySelector('#jurusan-input').value = response
                                .jurusan;
                            editForm.querySelector('#fakultas-input').value = response
                                .fakultas;
                        }
                    });
                });
            });

            Array.from(deleteBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteForm.setAttribute('action', btn.getAttribute('data-url'));
                });
            });


        });
    </script>
@endpush
