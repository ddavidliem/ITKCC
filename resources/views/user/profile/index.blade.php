@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="d-flex justify-content-evenly">
            <div class="col-lg-3 px-2">
                <div class="bg-white rounded border-1 min-vh-25 p-3 list-group list-group-flush">
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#profileImgModal">
                        Update Foto Profile
                    </button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#editModal">Edit Profile</button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#sertifikatModal">
                        Sertifikat
                    </button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#pengalamanModal">Pengalaman</button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#skillModal">Skill</button>
                    <a href="/Home/User/Resume" class="list-group-item list-group-item-action fs-6 fw-semibold">Resume</a>
                </div>
            </div>
            <div class="col-lg-9">
                @if (!$user->profile || $user->Resume)
                    <div class="mb-4 col-lg-12 p-2 bg-warning rounded border-1">
                        <ul class="list-unstyled">
                            @if (!$user->profile)
                                <li>
                                    <p class="fw-semibold text-center">Kamu Belum Mengupload Foto Profile</p>
                                </li>
                            @endif
                            @if (!$user->resume)
                                <li>
                                    <p class="fw-semibold text-center">Kamu Belum Mengupload Resume</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
                <div class="modal fade" id="profileImgModal" tabindex="-1" aria-labelledby="profileImgModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="profileImgModal">Form Upload Foto Profile</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="/update-profile-image" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <h2 class="text-capitalize text-center">Upload File Foto</h2>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="profile_img"
                                            aria-describedby="profile_img" aria-label="Upload" name="profile_img" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal  fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModal">Data Diri</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-labelledby="close"></button>
                            </div>
                            <form action="/update-profile" method="POST">
                                @csrf
                                <div class="modal-body min-vh-50 scroll-modal">
                                    <div class="mb-2 p-3">
                                        <label for="editName" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="editName" name="editName"
                                            value="{{ $user->nama_lengkap }}">
                                    </div>
                                    <div class="mb-2 p-3">
                                        <label for="editEmail" class="form-label">Alamat Email</label>
                                        <input type="email" class="form-control" id="editEmail" name="editEmail"
                                            value="{{ $user->alamat_email }}">
                                    </div>
                                    <div class="mb-2 p-3">
                                        <label for="editNomorTelepon" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="editNomorTelepon"
                                            name="editNomorTelepon" value="{{ $user->nomor_telepon }}">
                                    </div>
                                    <div class="mb-2 p-3">
                                        <label for="editTempatKelahiran" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="editTempatKelahiran"
                                            name="editTempatKelahiran" value="{{ $user->tempat_lahir }}">
                                    </div>
                                    <div class="mb-2 p-3">
                                        <label for="editTanggalLahir" class="form-label"> Tanggal Lahir</label>
                                        <input type="text" class="form-control" id="editTanggalLahir"
                                            name="editTanggalLahir" value="{{ $user->tanggal_lahir }}">
                                    </div>
                                    <div class="mb-2 p-3">
                                        <label for="editAlamat" class="form-label">Alamat/Tempat Tinggal</label>
                                        <input type="text" class="form-control" id="editAlamat" name="editAlamat"
                                            value="{{ $user->alamat }}">
                                    </div>
                                    <div class="mb-2 p-3">
                                        <label for="editKota" class="form-label">Kota</label>
                                        <input type="text" class="form-control" id="editKota" name="editKota"
                                            value="{{ $user->kota }}">
                                    </div>

                                    <div class="row">
                                        <button type="submit" class="btn btn-primary col-lg-10 offset-1">Update</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="modal fade " id="sertifikatModal" tabindex="-1" aria-labelledby="sertifikatModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="sertifikatModal">Tambah Sertifikat</h1>
                                <button class="btn-close" type="button" data-bs-dismiss="modal"aria-label="Close">
                                </button>
                            </div>
                            <form action="/submit-sertifikat" method="POST">
                                @csrf
                                <div class="modal-body min-vh-50 scroll-modal p-4">
                                    <div class="mb-3 row">
                                        <label for="bidang_sertifikat"
                                            class="text-capitalized col-sm-2 col-form-label">Bidang
                                            Sertifikat</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="bidang_sertifikat"
                                                name="bidang_sertifikat" placeholder="Bidang Sertifikat">
                                        </div>
                                        @if ($errors->has('bidang_sertifikat'))
                                            <div class="error">{{ $errors->first('bidang_sertifikat') }}</div>
                                        @endif
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="level"
                                            class="text-capitalized col-sm-2 col-form-label">Level</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="level" name="level"
                                                placeholder="Level">
                                        </div>
                                        @if ($errors->has('level'))
                                            <div class="error">{{ $errors->first('level') }}</div>
                                        @endif
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="nomor"
                                            class="text-capitalized col-sm-2 col-form-label">nomor</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="nomor" name="nomor"
                                                placeholder="Nomor">
                                        </div>
                                        @if ($errors->has('nomor'))
                                            <div class="error">{{ $errors->first('nomor') }}</div>
                                        @endif
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="lembaga_sertifikat"
                                            class="text-capitalized col-sm-2 col-form-label">lembaga sertifikat</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="lembaga_sertifikat"
                                                name="lembaga_sertifikat" placeholder="Lembaga Sertifikat">
                                        </div>
                                        @if ($errors->has('lembaga_sertifikat'))
                                            <div class="error">{{ $errors->first('lembaga_sertifikat') }}</div>
                                        @endif
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="judul_sertifikasi"
                                            class="text-capitalized col-sm-2 col-form-label">Judul
                                            Sertifikasi</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="judul_sertifikasi"
                                                name="judul_sertifikasi" placeholder="Judul Sertifikasi">
                                        </div>
                                        @if ($errors->has('judul_sertifikasi'))
                                            <div class="error">{{ $errors->first('judul_sertifikasi') }}</div>
                                        @endif
                                        <button type="submit"
                                            class="col-6 offset-3 btn btn-primary :hover">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

                <div class="modal fade" id="pengalamanModal" tabindex="-1" aria-labelledby="pengalamanModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="pengalamanModal">Tambah Pengalaman</h1>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <form action="/submit-pengalaman" method="POST">
                                @csrf
                                <div class="modal-body min-vh-50 scroll-modal p-4">
                                    <div class="mb-3 row">
                                        <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama
                                            Perusahaan</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="nama_perusahaan"
                                                name="nama_perusahaan" placeholder="Nama Perusahaan">
                                        </div>
                                        @if ($errors->has('nama_perusahaan'))
                                            <div class="error">{{ $errors->first('nama_perusahaan') }}</div>
                                        @endif
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                        <div class="col-10">
                                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                                placeholder="Jabatan">
                                        </div>
                                        @if ($errors->has('Jabatan'))
                                            <div class="error">{{ $errors->first('Jabatan') }}</div>
                                        @endif
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="tahun-masuk" class="col-sm-2 col-form-label">Tahun Masuk</label>
                                        <div class="col-10">
                                            <input type="number" class="form-control" id="tahun_masuk"
                                                name="tahun_masuk" placeholder="Tahun Masuk">
                                        </div>
                                        @if ($errors->has('tahun_masuk'))
                                            <div class="error">{{ $errors->first('tahun_masuk') }}</div>
                                        @endif
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="tahun-keluar" class="col-sm-2 col-form-label">Tahun Keluar</label>
                                        <div class="col-10">
                                            <input type="number" class="form-control" id="tahun_keluar"
                                                name="tahun_keluar" placeholder="Tahun Keluar">
                                        </div>
                                        @if ($errors->has('tahun_keluar'))
                                            <div class="error">{{ $errors->first('tahun_keluar') }}</div>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary col-6 offset-3 :hover">Submit</button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
                <div id="profile"></div>
            </div>
        </div>

    </div>
    </div>
@endsection

@push('script')
    <script type="module">
        $(document).ready(function () {
            var renderProfile = function(){
                $.ajax({
                    type: "GET",
                    url: "/render-profile",
                    dataType: "json",
                    success: function (response) {
                        $('#profile').html(response.profile);
                    }
                });
            }

            renderProfile();
        });
    
</script>
@endpush
