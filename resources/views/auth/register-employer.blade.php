@extends('layouts.app')

@push('style')
@endpush

@section('content')
    <div>
        <div class="container mt-2 p-4">
            <div class="row">
                <h1 class="text-center">Formulir Pendaftaran Penyedia Kerja</h1>
            </div>
            <form action="/employer-submit-approval" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="row">
                        <h1>Data Login</h1>
                    </div>

                    <div class="row">
                        <div class="mb-3 row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username Untuk Login" required>
                            </div>
                            @if ($errors->has('username'))
                                <div class="error">{{ $errors->first('username') }}</div>
                            @endif
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password Untuk Login" required>
                            </div>
                            @if ($errors->has('password'))
                                <div class="error"{{ $errors->first('password') }}></div>
                            @endif
                        </div>
                        <div class="mb-3 row">
                            <label for="passwordconfirmation" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Konfirmasi Password"required>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <div class="error">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="row">
                        <h1>Data Penyedia Kerja</h1>
                    </div>

                    <div class="row">

                        <div class="mb-3 row">
                            <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                    placeholder="Nama Perusahaan">
                            </div>
                            @if ($errors->has('nama_perusahaan'))
                                <div class="error">{{ $errors->first('nama_perusahaan') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="Alamat">
                            </div>
                            @if ($errors->has('alamat'))
                                <div class="error">{{ $errors->first('alamat') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="Provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="provinsi" name="provinsi"
                                    placeholder="Provinsi Perusahaan">
                            </div>
                            @if ($errors->has('provinsi'))
                                <div class="error">{{ $errors->first('provinsi') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="kota" class="col-sm-2 col-form-label">Kota</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kota" name="kota"
                                    placeholder="Kota Perusahaan">
                            </div>
                            @if ($errors->has('kota'))
                                <div class="error">{{ $errors->first('kota') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="kodePos" class="col-sm-2 col-form-label">Kode Pos</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kode_pos" placeholder="Kode Pos"
                                    name="kode_pos">
                            </div>
                            @if ($errors->has('kode_pos'))
                                <div class="error">{{ $errors->first('kode_pos') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="website" class="col-sm-2 col-form-label">Website</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="website" name="website"
                                    placeholder="Website Perusahaan">
                            </div>
                            @if ($errors->has('website'))
                                <div class="error">{{ $errors->first('website') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                    placeholder="Nama Lengkap">
                            </div>
                            @if ($errors->has('nama_lengkap'))
                                <div class="error">{{ $errors->first('nama_lengkap') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                    placeholder="Jabatan">
                            </div>
                            @if ($errors->has('jabatan'))
                                <div class="error">{{ $errors->first('jabatan') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="nomor_telepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon"
                                    placeholder="Nomor Telepon">
                            </div>
                            @if ($errors->has('nomor_telepon'))
                                <div class="error">{{ $errors->first('nomor_telepon') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="alamat_email" class="col-sm-2 col-form-label">Alamat Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat_email" name="alamat_email"
                                    placeholder="Alamat Email">
                            </div>
                            @if ($errors->has('alamat_email'))
                                <div class="error">{{ $errors->first('alamat_email') }}</div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <label for="formulir" class="col-sm-2 col-form-label">Formulir</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="formulir" name="formulir" required>
                            </div>
                            @if ($errors->has('formulir'))
                                <div class="error">
                                    {{ $errors->first('formulir') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3 row">
                            <div class="captcha">
                                <span class="fs-2">{!! captcha_img() !!}</span>
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

                <div>
                    <button type="submit" class="btn btn-primary col-lg-10 offset-1">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: '/refresh-captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
@endpush
