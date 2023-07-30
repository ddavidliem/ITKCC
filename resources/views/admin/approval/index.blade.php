@extends('layouts.admin')

@section('content')
    <div class=" p-3">
        <div class="d-flex">
            <div class="col-lg-2">
                <div class="min-vh-10 bg-white rounded border-1 list-group list-group-flush p-2" role="tablist" id="tablist">
                    <a href="" class="list-group-item fw-semibold active" type="buttton" role="tab"
                        data-bs-toggle="tab" data-bs-target="#pendingTabList">
                        Pending
                    </a>
                    <a href="" class="list-group-item fw-semibold" type="button" role="button" data-bs-toggle="tab"
                        data-bs-target="#approveTabList">
                        Approved
                    </a>
                </div>
            </div>

            <div class="col-lg-10 px-3 tab-content" id="tab-content">

                <div class="min-vh-100 tab-pane fade show active" tabindex="0" id="pendingTabList" role="tabpanel">
                    <div class="bg-white min-vh-10 mb-2 p-4">
                        <h4 class="fw-semibold">Pending Approval</h4>
                    </div>
                    <div class="d-flex">
                        <div class="col-lg-4">
                            <div class="bg-white rounded border-1 min-vh-25 max-vh-100 overflow-auto list-group list-group-flush p-4"
                                role="tablist">
                                @if ($pending->isEmpty())
                                    @include('component.empty')
                                @else
                                    @foreach ($pending as $item)
                                        <a href="" type="button" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-{{ $item->id }}" aria-controls="{{ $item->id }}"
                                            class="list-group-item p-2 rounded" data-toggle="tab">
                                            <div class="mx-2">
                                                <span class="fs-4">{{ $item->nama_perusahaan }}</span>
                                                <br>
                                                <small class="fs-6 fw-semibold">{{ $item->nama_lengkap }}</small>
                                                <br>
                                                <small class="fs-6 fw-semibold">{{ $item->nomor_telepon }}</small>
                                                <br>
                                                <small class="fs-6">{{ $item->status }}</small>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-8 px-2" id="pendingContent">
                            <div class="bg-white rounded border-1 min-vh-100 tab-content">
                                @foreach ($pending as $item)
                                    <div class="p-4 tab-pane" id="tab-{{ $item->id }}" role="tabpanel" tabindex="0">
                                        <div>
                                            <h4 class="fw-semibold text-capitalize">{{ $item->nama_perusahaan }}</h4>
                                            <small>{{ $item->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="my-4">
                                            <form action="/approval-approved/{{ $item->id }}" method="post">
                                                @csrf
                                                <button class="btn btn-primary" type="submit">Approve</button>
                                            </form>
                                        </div>
                                        <div class="">
                                            <h4>Informasi Perusahaan</h4>
                                            <div class="my-3 max-vh-50 overflow-auto">
                                                <div>
                                                    <label for="" class="col-form-label">Nama Perusahaan</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_perusahaan }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Alamat</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->alamat }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Provinsi</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->provinsi }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Kota</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->kota }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Kode Pos</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->kode_pos }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Website</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->website }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Informasi Employer</h4>
                                            <div class="my-3 max-vh-50 overflow-auto">
                                                <div>
                                                    <label for="" class="col-form-label">Nama Lengkap</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_lengkap }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Jabatan</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_lengkap }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Nomor Telepon</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_lengkap }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Alamat Email</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->alamat_email }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Resume</h4>
                                            <div>
                                                <iframe src="{{ asset('formulir/' . $item->formulir) }}" frameborder="0"
                                                    width="100%" height="600px"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <div class="min-vh-100 tab-pane fade show" tabindex="0" id="approveTabList" role="tabpanel">
                    <div class="bg-white min-vh-10 mb-2 p-4">
                        <h4 class="fw-semibold">Approved Approval</h4>
                    </div>
                    <div class="d-flex">
                        <div class="col-lg-4">
                            <div class="bg-white rounded border-1 min-vh-25 max-vh-100 overflow-auto list-group list-group-flush p-4"
                                role="tablist">
                                @if ($pending->isEmpty())
                                    @include('component.empty')
                                @else
                                    @foreach ($approved as $item)
                                        <a href="" type="button" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-approved-{{ $item->id }}"
                                            aria-controls="{{ $item->id }}" class="list-group-item p-2 rounded"
                                            data-toggle="tab">
                                            <div class="mx-2">
                                                <span class="fs-4">{{ $item->nama_perusahaan }}</span>
                                                <br>
                                                <small class="fs-6 fw-semibold">{{ $item->nama_lengkap }}</small>
                                                <br>
                                                <small class="fs-6 fw-semibold">{{ $item->nomor_telepon }}</small>
                                                <br>
                                                <small class="fs-6">{{ $item->status }}</small>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-8 px-2" id="approveContent">
                            <div class="bg-white rounded border-1 min-vh-100 tab-content">
                                @foreach ($approved as $item)
                                    <div class="p-4 tab-pane" id="tab-approved-{{ $item->id }}" role="tabpanel"
                                        tabindex="0">
                                        <div>
                                            <h4 class="fw-semibold text-capitalize">{{ $item->nama_perusahaan }}</h4>
                                            <small>{{ $item->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="my-4">
                                            <a href="" class="btn btn-primary">Approve</a>
                                        </div>
                                        <div class="">
                                            <h4>Informasi Perusahaan</h4>
                                            <div class="my-3 max-vh-50 overflow-auto">
                                                <div>
                                                    <label for="" class="col-form-label">Nama Perusahaan</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_perusahaan }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Alamat</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->alamat }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Provinsi</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->provinsi }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Kota</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->kota }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Kode Pos</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->kode_pos }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Website</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->website }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Informasi Employer</h4>
                                            <div class="my-3 max-vh-50 overflow-auto">
                                                <div>
                                                    <label for="" class="col-form-label">Nama Lengkap</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_lengkap }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Jabatan</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_lengkap }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Nomor Telepon</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->nama_lengkap }}">
                                                </div>
                                                <div>
                                                    <label for="" class="col-form-label">Alamat Email</label>
                                                    <input type="text" readonly class="form-control"
                                                        value="{{ $item->alamat_email }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h4>Resume</h4>
                                            <div>
                                                <iframe src="{{ asset('formulir/' . $item->formulir) }}" frameborder="0"
                                                    width="100%" height="600px"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    @endsection
