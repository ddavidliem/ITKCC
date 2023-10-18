@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="min-vh-15 bg-white rounded p-4 d-flex">
            <div class="col-3 d-flex align-items-center">
                <h3 class="fw-semibold col-4 ">Permohonan Perusahaan</h3>
            </div>
            <div class="col-6 d-flex">
                <div class="mx-4">
                    <h6 class="fw-semibold">Total Permohonan</h6>
                    <h6 class="fw-semibold">{{ $total }}</h6>
                </div>
                <div class="mx-4">
                    <h6 class="fw-semibold">Disetujui</h6>
                </div>
                <div class="mx-4">
                    <h6 class="fw-semibold">Menunggu</h6>
                </div>
                <div class="mx-4">
                    <h6 class="fw-semibold">Tidak Disetujui</h6>
                </div>
            </div>
            <div class="col-3 p-1">
                <form action="">
                    @csrf
                    <div class="my-1">
                        <input type="text" role="search" placeholder="Cari Permohonan" class="form-control">
                    </div>
                    <div class="my-1">
                        <select name="" class="form-select" id="">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="approved">Disetujui</option>
                            <option value="pending">Menunggu</option>
                            <option value="not approved">Tidak Disetujui</option>
                        </select>
                    </div>
                    <div class="my-2 d-flex justify-content-end">
                        <button class="btn btn-outline-dark px-4">Cari</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="my-2 d-flex">
            <div class="col-3">
                <div class="p-4 bg-white rounded min-vh-100 max-vh-100 overflow-auto">
                    <div class="">
                        <h6 class="fw-semibold">Daftar Permohonan Perusahaan</h6>
                    </div>
                    <div class="list-group list-group-flush my-4" role="tablist" id="tablist">
                        @if ($approval->isEmpty())
                            @include('component.empty', ['message' => 'Belum Ada Approval'])
                        @else
                            @foreach ($approval as $item)
                                <a href="" type="button" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-{{ $item->id }}" class="list-group-item p-2 d-flex rounded"
                                    aria-controls="{{ $item->id }}">
                                    <div class="col-8 mx-2">
                                        <h6 class="fw-semibold my-2 text-capitalize">{{ $item->nama_perusahaan }}</h6>
                                        <ul class="list-unstyled">
                                            <li class="text-capitalize">{{ $item->nama_lengkap }}</li>
                                            <li class="text-capitalize">{{ $item->jabatan }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-capitalize">{{ $item->status }}</h6>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            <div class="col-9 mx-2">
                <div class="p-4 bg-white rounded min-vh-100">
                    <div class="tab-content" id="tab-content">
                        @foreach ($approval as $item)
                            <div id="tab-{{ $item->id }}" class="p-2 tab-pane" role="tabpanel">
                                <div class="bg-white p-44 min-vh-10 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div>
                                                <h3 class="fw-bold">Detail Permohonan</h3>
                                                <div class="my-3">
                                                    <h6>Nomor Approval : <span
                                                            class="fw-semibold">{{ $item->id }}</span>
                                                    </h6>
                                                    <h6>Tanggal Permohonan : <span
                                                            class="fw-semibold">{{ $item->created_at }}</span></h6>
                                                    @if ($item->status === 'approved')
                                                        <h6>Approved : <span
                                                                class="fw-semibold">{{ $item->updated_at }}</span></h6>
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
                                            @if ($item->status === 'approved')
                                                <h5 class="mx-4" class="text-success fw-semibold">Approved</h5>
                                            @elseif($item->status === 'not approved')
                                                <h5 class="mx-4" class="text-danger fw-semibold">Not Approved</h5>
                                            @elseif($item->status === 'pending')
                                                <h5 class="mx-4" class="text-dark fw-semibold">Pending</h5>
                                            @endif
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-dark status-button" data-bs-toggle="modal"
                                                data-bs-target="#approvalModal" data-url="/update-approval/{$item->id}"
                                                data-content="">Status</button>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <h5 class="fw-semibold">Informasi Perusahaan</h5>
                                        <div class="d-flex">
                                            <div class="col-5 mx-2">
                                                <div class="my-1">
                                                    <label for="" class="form-label">Nama Perusahaan</label>
                                                    <h6 class="fw-semibold text-capitalize">{{ $item->nama_lengkap }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Alamat</label>
                                                    <h6 class="fw-semibold">{{ $item->alamat }}</h6>
                                                </div>
                                                <div class="my-1">
                                                    <label for="" class="form-label">Provinsi</label>
                                                    <h6 class="fw-semibold">{{ $item->provinsi }}</h6>
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

    @include('admin.modal.approval')
@endsection

@push('script')
    <script type="module"></script>
@endpush
