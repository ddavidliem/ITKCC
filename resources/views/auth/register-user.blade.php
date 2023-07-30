@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <div>
        <div class="container mt-2 p-4">
            <div class="row">
                <h1 class="text-center">Formulir Pendaftaran Pencari Kerja</h1>
            </div>
            <form action="/register-user" method="POST" class="form-validation" novalidate>
                @csrf
                <div class="row">

                    <div class="row">
                        <h1>Data Login</h1>
                    </div>

                    <div class="row">
                        <div class="mb-3 row">
                            <label for="username" class="col-2 col-form-label">Username</label>
                            <div class="col-10">
                                <input type="text" required class="form-control" id="username" name="username"
                                    placeholder="Username Untuk Login">
                            </div>
                            @if ($errors->has('username'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('username') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-2 col-form-label">Password</label>
                            <div class="col-10">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password Untuk Login">
                            </div>
                            @if ($errors->has('password'))
                                <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="mb-3 row">
                            <label for="passwordconfirmation" class="col-2 col-form-label">Konfirmasi Password</label>
                            <div class="col-10">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Konfirmasi Password">
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <div class="error">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="row">
                        <h1>Data Pribadi</h1>
                    </div>

                    <div class="row">

                        <div class="mb-3 row">
                            <label for="namaLengkap" class="col-2 col-form-label">Nama Lengkap</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                    placeholder="Nama Lengkap">
                            </div>
                            @if ($errors->has('nama_lengkap'))
                                <div class="error">{{ $errors->first('nama_lengkap') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-2 col-form-label">Alamat Email</label>
                            <div class="col-10">
                                <input type="email" class="form-control" id="alamat_email" name="alamat_email"
                                    placeholder="Alamat Email">
                            </div>
                            @if ($errors->has('alamat_email'))
                                <div class="error">{{ $errors->first('alamat_email') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="tempatLahir" class="col-2 col-form-label">tempat Lahir</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    placeholder="Contoh : Balikpapan">
                            </div>
                            @if ($errors->has('tempat_lahir'))
                                <div class="error">{{ $errors->first('tempat_lahir') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="join"class="col-2 col-form-label">{{ __('Date of Birth') }}</label>
                            <div class="col-10">
                                <input type="date" class="form-control" name="tanggal_lahir" id="datepicker">
                            </div>
                            @if ($errors->has('tanggal_lahir'))
                                <div class="error">{{ $errors->first('tanggal_lahir') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="nomorKtp" class="col-2 col-form-label">Nomor KTP</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="nomor_ktp" name="nomor_ktp"
                                    placeholder="Contoh : 123456789011112">
                            </div>
                            @if ($errors->has('nomor_ktp'))
                                <div class="error">{{ $errors->first('nomor_ktp') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="jenisKelamin" class="col-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-10">
                                <select class="form-select" aria-label="Default select example" name="jenis_kelamin"
                                    id="jenis_kelamin">
                                    <option selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="pria">Pria</option>
                                    <option value="wanita">Wanita</option>
                                </select>
                            </div>
                            @if ($errors->has('jenis_kelamin'))
                                <div class="error">{{ $errors->first('jenis_kelamin') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="alamat" class="col-2 col-form-label">Alamat</label>
                            <div class="col-10">
                                <textarea name="alamat" class="form-control" placeholder="Alamat" id="alamat" name="alamat" cols="20"
                                    rows="5"></textarea>
                            </div>
                            @if ($errors->has('alamat'))
                                <div class="error">{{ $errors->first('alamat') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="kota" class="col-2 col-form-label">Kota/Kabupaten</label>
                            <div class="col-10">
                                <select class="form-select" aria-label="Default select example" name="kota"
                                    id="kota">
                                    <option value="Balikpapan">Balikpapan</option>
                                    {{-- Gunakan Ajax Dari Database --}}
                                </select>
                            </div>
                            @if ($errors->has('kota'))
                                <div class="error">{{ $errors->first('kota') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="kodePos" class="col-2 col-form-label">Kode Pos</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="kode_pos" placeholder="Kode Pos"
                                    name="kode_pos">
                            </div>
                            @if ($errors->has('kode_pos'))
                                <div class="error">{{ $errors->first('kode_pos') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="nomorTelepon" class="col-2 col-form-label">Nomor Telepon</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon"
                                    placeholder="Nomor Telepon">
                            </div>
                            @if ($errors->has('nomor_telepon'))
                                <div class="error">{{ $errors->first('nomor_telepon') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="kewarganegaraan" class="col-2 col-form-label">Kewarganegaraan</label>
                            <div class="col-10">
                                <select class="form-select" aria-label="Default select example" name="kewarganegaraan"
                                    id="kewarganegaraan">
                                    <option selected>Pilih Kewarganegaraan</option>
                                    <option value="1">WNI</option>
                                    <option value="2">WNA</option>
                                </select>
                            </div>
                            @if ($errors->has('kewarganegaraan'))
                                <div class="error">{{ $errors->first('kewarganegaraan') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="status_perkawinan" class="col-2 col-form-label">Status Perkawinan</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="status_perkawinan"
                                    name="status_perkawinan" placeholder="Status Perkawinan">
                            </div>
                            @if ($errors->has('status_perkawinan'))
                                <div class="error">{{ $errors->first('status_perkawinan') }}</div>
                            @endif
                        </div>


                        <div class="mb-3 row">
                            <label for="agama" class="col-2 col-form-label">Agama</label>
                            <div class="col-10">
                                <select class="form-select" aria-label="Default select example" name="agama"
                                    id="agama">
                                    <option value="Kristen" selected>Kristen</option>
                                </select>
                            </div>
                            @if ($errors->has('agama'))
                                <div class="error">{{ $errors->first('agama') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="pendidikan_tertinggi" class="col-2 col-form-label">Pendidikan Tertinggi</label>
                            <div class="col-10">
                                <select class="form-select" aria-label="Default select example"
                                    name="pendidikan_tertinggi" id="pendidikan_tertinggi">
                                    <option value="SMA" selected>SMA</option>
                                </select>
                            </div>
                            @if ($errors->has('pendidikan'))
                                <div class="error">{{ $errors->first('pendidikan') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="nim" class="col-2 col-form-label">NIM</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="nim" name="nim"
                                    placeholder="Kosongkan Jika Bukan Alumni ITK">
                            </div>
                            @if ($errors->has('nim'))
                                <div class="error">{{ $errors->first('nim') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="ipk" class="col-2 col-form-label">IPK</label>
                            <div class="col-10">
                                <input type="float" class="form-control" id="ipk" name="ipk"
                                    placeholder="IPK">
                            </div>
                            @if ($errors->has('ipk'))
                                <div class="error">{{ $errors->first('ipk') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="bidang" class="col-2 col-form-label">Bidang</label>
                            <div class="col-10">
                                <select class="form-select" aria-label="Default select example" id="bidang"
                                    name="bidang">
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                </select>
                            </div>
                            @if ($errors->has('bidang'))
                                <div class="error">{{ $errors->first('bidang') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="disabilitas" class="col-2 col-form-label">Jika Anda Penyandang Disabilitas,
                                Tuliskan Disini</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="disabilitas" name="disabilitas"
                                    placeholder="Disabilitas">
                            </div>
                            @if ($errors->has('disabilitas'))
                                <div class="error">{{ $errors->first('disabilitas') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <div class="captcha">
                                <span class="">{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>

                        </div>

                        <div class="mb-3 row">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                name="captcha">
                            @if ($errors->has('captcha'))
                                <div class="error">{{ $errors->first('captcha') }}</div>
                            @endif
                        </div>


                    </div>
                </div>

                <div class="row">
                    <button type="submit" class="col-lg-10 offset-1 btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('script')
    <script type="module">
                $('#reload').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '/refresh-captcha',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });

            
</script>
@endpush
