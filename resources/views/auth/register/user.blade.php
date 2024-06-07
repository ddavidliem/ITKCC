@extends('layouts.app')

@section('content')
    <div class="col-8 offset-2 p-4">
        <div class="bg-white p-4 rounded">
            <h5 class="fw-bold">Form Pendaftaran User</h5>
            <div class="my-2 p-4 max-vh-100 overflow-auto">
                <form action="/register-user" method="post" class="needs-validation" novalidate>
                    @csrf
                    <div class="">
                        <h6 class="fw-semibold">Informasi Login</h6>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" placeholder="username"
                                class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}"
                                required>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" placeholder="password"
                                class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                                required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-2">
                            <label for="" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="konfirmasi password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                value="{{ old('password_confirmation') }}" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="my-4">
                        <h6 class="fw-semibold">Informasi Pribadi</h6>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" placeholder="nama lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Alamat Email</label>
                            <input type="email" name="alamat_email" placeholder="alamat email aktif"
                                class="form-control @error('alamat_email') is-invalid @enderror"
                                value="{{ old('alamat_email') }}" required>
                            @error('alamat_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" placeholder="tempat lahir"
                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                value="{{ old('tempat_lahir') }}" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                id="" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                value="{{ old('alamat') }}" required>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Kota</label>
                            <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                                value="{{ old('kota') }}" required>
                            @error('kota')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Kode Pos</label>
                            <input type="text" name="kode_pos"
                                class="form-control @error('kode_pos') is-invalid @enderror"
                                value="{{ old('kode_pos') }}" required>
                            @error('kode_pos')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon"
                                class="form-control @error('nomor_telepon') is-invalid @enderror"
                                value="{{ old('nomor_telepon') }}" required>
                            @error('nomor_telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Kewarganegaraan</label>
                            <select name="kewarganegaraan"
                                class="form-select @error('kewarganegaraan') is-invalid @enderror" id=""
                                required>
                                <option value="" selected disabled>Pilih Kewarganegaraan</option>
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                            </select>
                            @error('kewarganegaraan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Status Perkawinan</label>
                            <select name="status_perkawinan"
                                class="form-select @error('status_perkawinan') is-invalid @enderror" id=""
                                required>
                                <option value="" disabled selected>Pilih Status Perkawinan</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                            @error('status_perkawinan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Agama</label>
                            <select name="agama" class="form-select @error('agama') is-invalid @enderror" required>
                                <option value="" selected disabled>Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Pendidikan Tertinggi</label>
                            <select name="pendidikan"
                                class="form-select @error('pendidikan_tertinggi') is-invalid @enderror" id="">
                                <option value="" disabled selected>Pilih Pendidikan Tertinggi</option>
                                <option value="Sekolah Dasar">Sekolah Dasar</option>
                                <option value="Sekolah Menengah Pertama">Sekolah Menengah Pertama</option>
                                <option value="Sekolah Menengah Atas">Sekolah Menengah Atas</option>
                                <option value="Diploma 1">Diploma 1</option>
                                <option value="Diploma 2">Diploma 2</option>
                                <option value="Diploma 3">Diploma 3</option>
                                <option value="Strata 1">Strata 1</option>
                                <option value="Strata 2">Strata 2</option>
                                <option value="Strata 3">Strata 3</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim') }}" name="nim">
                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">IPK</label>
                            <input type="text" class="form-control @error('ipk') is-invalid @enderror"
                                value="{{ old('IPK') }}" name="ipk">
                            @error('ipk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="fw-semibold form-label">Program Studi</label>
                            <select name="program_studi" class="form-select @error('program_studi') is-invalid @enderror"
                                id="" name="program_studi">
                                <option value="" disabled selected>Pilih Program Studi</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->program_studi }}">{{ $item->program_studi }}</option>
                                @endforeach
                            </select>
                            @error('program_studi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label fw-semibold">Jika Penyandang Disabilitas Tuliskan
                                Disini</label>
                            <input type="text" class="form-control @error('disabilitas') is-invalid @enderror"
                                value="{{ old('disabilitas') }}" name="disabilitas">
                            @error('disabilitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="my-3">
                            <div class="captcha">
                                <span class="">{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>
                        <div class="my-3">
                            <input id="captcha" type="text"
                                class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha"
                                name="captcha" required>
                            @error('captcha')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="my-4 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">Register</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: '/refresh-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });

        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endpush
