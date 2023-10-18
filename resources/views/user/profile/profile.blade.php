<div class="rounded p-4 bg-white min-vh-50 mb-3">
    <h2 class="fw-bold">Informasi Pribadi</h2>
    <div class="d-flex justify-content-center">
        @if ($user->profile)
            <div class="mb-1 row col-4">
                <div class="p-4">
                    <img src="{{ asset('profile/' . $user->profile) }}" class="img-profile">
                </div>
            </div>
        @endif

        <div class="row mx-4 col-8 d-flex" id="section-biodata">
            <div class="col-4">
                <div class="my-1">
                    <label for="" class="form-label">Nama Lengkap</label>
                    <h6 class="fw-semibold">{{ $user->nama_lengkap }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Email</label>
                    <h6 class="fw-semibold">{{ $user->alamat_email }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Nomor Telepon</label>
                    <h6 class="fw-semibold">{{ $user->nomor_telepon }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Kota</label>
                    <h6 class="fw-semibold text-capitalize">{{ $user->kota }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Alamat</label>
                    <h6 class="fw-semibold">{{ $user->alamat }}</h6>
                </div>
            </div>
            <div class="col-4 mx-4">
                <div class="my-1">
                    <label for="" class="form-label">Tempat Kelahiran</label>
                    <h6 class="fw-semibold text-capitalize">
                        {{ $user->tempat_lahir }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Tanggal Lahir</label>
                    <h6 class="fw-semibold">{{ $user->tanggal_lahir }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Jenis Kelamin</label>
                    <h6 class="fw-semibold text-capitalize">
                        {{ $user->jenis_kelamin }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Kewarganegaraan</label>
                    <h6 class="fw-semibold text-capitalize">
                        {{ $user->kewarganegaraan }}</h6>
                </div>
                <div class="my-1">
                    <label for="" class="form-label">Agama</label>
                    <h6 class="fw-semibold text-capitalize">{{ $user->agama }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rounded border p-4 bg-white my-3">
    <div class="d-flex justify-content-between">
        <h2 class="fw-bold">Pengalaman</h2>
        <a href="/Home/User/Pengalaman" class="text-decoration-none text-dark">Edit</a>
    </div>
    <div class="p-2 list-group list-group-flush min-vh-50 overflow-auto">
        @if ($pengalaman->isEmpty())
            @include('component.empty', ['message' => 'Tidak Ada Pengalaman'])
        @else
            @foreach ($pengalaman as $item)
                <div class="list-group-item">
                    <div>
                        <h5 class="text-capitalize fw-semibold">{{ $item->title }}</h5>
                        <ul class="list-unstyled">
                            <li class="text-capitalize">{{ $item->organisasi }} | {{ $item->jenis_pekerjaan }}</li>
                            <li class="text-capitalize">{{ $item->tanggal_mulai }} - {{ $item->tanggal_selesai }}
                            </li>
                            @if (!empty($item->deskripsi))
                                <li><a href="" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#description-{{ $item->id }}"aria-expanded="false"
                                        class="text-decoration-none text-muted">See More</a></li>
                                <li>
                                    <div class="collapse" id="description-{{ $item->id }}">
                                        <p>{!! nl2br($item->deskripsi) !!}</p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<div class="rounded border p-4 bg-white min-vh-25 my-3">
    <div class="d-flex justify-content-between">
        <h2 class="fw-bold">Sertifikat</h2>
        <a href="/Home/User/Sertifikat" class="text-decoration-none text-dark">Edit</a>
    </div>
    <div class="p-2 list-group list-group-flush min-vh-50 overflow-auto">
        @if ($sertifikasi->isEmpty())
            @include('component.empty', ['message' => 'Tidak Ada Sertifikat'])
        @else
            @foreach ($sertifikasi as $item)
                <div class="list-group-item">
                    <div>
                        <h5 class="text-capitalize fw-semibold">{{ $item->title }}</h5>
                        <ul class="list-unstyled">
                            <li class="text-capitalize">{{ $item->organisasi }}</li>
                            <li class="text-capitalize">{{ $item->tanggal_terbit }}</li>
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
