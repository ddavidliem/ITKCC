<div class="col-lg-12 rounded border-1 p-4 bg-white min-vh-50">
    <div class="p-4" id="section-biodata">
        <h2>Informasi Pribadi</h2>
        <div class="d-flex justify-content-between">
            @if ($user->profile)
                <div class="mb-1 row col-lg-4">
                    <div class="row d-flex justify-content-center">
                        <img src="{{ asset('profile/' . $user->profile) }}" alt="" class="rounded"
                            style="width:200px; height:200px">
                    </div>
                </div>
            @endif

            <div class="mb-1 row px-1 col-lg-8" id="section-biodata">
                <label class="col-lg-4 col-form-label fs-6">Nama Lengkap</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6"
                        value=": {{ $user->nama_lengkap }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Email</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6"
                        value=": {{ $user->alamat_email }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Nomor Telepon</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6"
                        value=": {{ $user->nomor_telepon }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Jenis Kelamin</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->jenis_kelamin }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Kewarganegaraan</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->kewarganegaraan }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Status</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->status_perkawinan }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Agama</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->agama }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Pendidikan Tertinggi</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->pendidikan_tertinggi }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Tempat / Tanggal Lahir</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->tempat_lahir }}, {{ $user->tanggal_lahir }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Alamat</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->alamat }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Kota</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->kota }}">
                </div>
                <label class="col-lg-4 col-form-label fs-6">Kode Pos</label>
                <div class="col-lg-8">
                    <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                        value=": {{ $user->kode_pos }}">
                </div>

                @if ($user->disabilitas)
                    <label class="col-lg-4 col-form-label fs-6">Disabilitas</label>
                    <div class="col-lg-8">
                        <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                            value=": {{ $user->disabilitas }}">
                    </div>
                @endif
                @if ($user->bidang)
                    <label class="col-lg-4 col-form-label fs-6">Bidang</label>
                    <div class="col-lg-8">
                        <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                            value=": {{ $user->bidang }}">
                    </div>
                @endif
                @if ($user->nim)
                    <label class="col-lg-4 col-form-label fs-6">NIM</label>
                    <div class="col-lg-8">
                        <input type="text" readonly class="form-control-plaintext fs-6 text-capitalize"
                            value=": {{ $user->nim }}">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 rounded border p-4 min-vh-50 my-4 bg-white">
    <h2>Pengalaman</h2>
    <div class="p-4 list-group list-group-flush min-vh-50 overflow-auto">
        @if ($pengalaman->isEmpty())
            @include('component.empty')
        @else
            @foreach ($pengalaman as $item)
                <div class=" p-4 mb-1 list-group-item">
                    <div>
                        <h4 class="text-capitalize">{{ $item->nama_perusahaan }}</h4>
                    </div>
                    <div>
                        <small class="text-capitalize">{{ $item->jabatan }}</small>
                        <br>
                        <small><span>{{ $item->tahun_masuk }}</span>-<span>{{ $item->tahun_keluar }}</span></small>
                    </div>

                </div>
            @endforeach
        @endif
    </div>
</div>
<div class="col-lg-12 rounded border p-4 min-vh-25 my-4 bg-white">
    <h2>Sertifikat</h2>
    <div class="p-4 list-group list-group-flush min-vh-50 overflow-auto">
        @if ($sertifikasi->isEmpty())
            @include('component.empty')
        @else
            @foreach ($sertifikasi as $item)
                <div class=" p-4 list-group-item">
                    <div>
                        <h4 class="text-capitalize">{{ $item->judul_sertifikasi }}</h4>
                    </div>
                    <div>
                        <small class="text-capitalize">{{ $item->lembaga_sertifikasi }}</small>
                        <br>
                        <small class="text-capitalize">level {{ $item->level }}</small>|
                        <small class="">{{ $item->nomor }}</small>
                    </div>

                </div>
            @endforeach
        @endif


    </div>
</div>
