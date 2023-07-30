@extends('layouts.employer')

@section('content')
    <div class="p-4 container">
        <div class="d-flex justify-content-between">
            <div class="col-lg-9 px-2">
                <div class="p-4 bg-white rounded border-1 min-vh-100">
                    <h2>Posted Job</h2>
                    <div class="list-group list-group-flush p-4 min-vh-100 overflow-auto">
                        @if ($loker->isEmpty())
                            @include('component.empty')
                        @else
                            @foreach ($loker as $item)
                                <a href="/loker-detail/{{ $item->id }}" class="list-group-item p-2 d-flex">
                                    <div class="d-flex">
                                        <div class="">
                                            <img src="{{ asset('logo/' . $item->employer->logo_perusahaan) }}" alt=""
                                                style="width:100px;height:70px">
                                        </div>
                                        <div class="mx-3">
                                            <div>
                                                <span class="fs-4 text-capitalize">{{ $item->nama_pekerjaan }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="fs-6 text-capitalize fw-semibold">{{ $item->employer->nama_perusahaan }}</span>
                                                <br>
                                                <span> <small class="text-capitalize">{{ $item->lokasi_pekerjaan }}</small>
                                                    | <small class="text-capitalize">{{ $item->jenis_pekerjaan }}</small>
                                                    | {{ $item->created_at->diffForHumans() }}</span>
                                                <br>
                                                <span>{{ $item->applicants_count }} Pelamar</span>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                {{-- <div class="p-4 bg-white rounded border-1 min-vh-10 mb-2 ">
                    <div class="d-flex">
                        @if ($employer->logo_perusahaan)
                            <div class="">
                                <img src="{{ asset('logo/' . $employer->logo_perusahaan) }}" style="width:70px;"
                                    class="text-center" alt="">
                            </div>
                        @endif
                        <div class="px-2">
                            <h3 class="text-center text-capitalize">{{ $employer->nama_perusahaan }}</h3>
                        </div>
                    </div>

                </div> --}}
                <div class="p-4 bg-white rounded border-1 min-vh-25 ">
                    @if ($employer->logo_perusahaan)
                        <p class="fw-semibold">Silahkan Menambah Lowongan Kerja Terbaru Disini</p>
                        <button class="btn btn-primary fs-5 px-2 col-lg-8 offset-2" data-bs-toggle="modal"
                            data-bs-target="#addLokerModal">Tambah Loker</button>
                    @else
                        <p class="fw-semibold">Silahkan melengkapi data perusahaan sebelum menambah lowongan kerja</p>
                    @endif

                </div>
            </div>
        </div>

        <div class="modal fade" id="addLokerModal" tabindex="-1" aria-labelledby="addLokerModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addLokerModal">Form Menambah Loker</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
                    </div>
                    <form action="/tambah-loker" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body min-vh-50 scroll-modal">
                            <div class="mb-1 p-2">
                                <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                                <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan"
                                    required>
                            </div>
                            <div class="mb-1 p-2">
                                <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                                <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-select" required>
                                    <option selected>Pilih Jenis Pekerjaan</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Contract">Contract</option>
                                    <option value="Volunteer">Volunteer</option>
                                    <option value="Internship">Internship</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-1 p-2">
                                <label for="tipe_pekerjaan" class="form-label">Tipe Pekerjaan</label>
                                <select name="tipe_pekerjaan" id="tipe_pekerjaan" class="form-select" required>
                                    <option selected>Pilih Tipe Pekerjaan</option>
                                    <option value="WFO">WFO</option>
                                    <option value="WFH">WFH</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                            </div>

                            <div class="mb-1 p-2">
                                <label for="lokasi_pekerjaan" class="form-label">Lokasi</label>
                                <input type="text" name="lokasi_pekerjaan" class="form-control" id="lokasi_pekerjaan"
                                    required>
                            </div>

                            <div class="mb-1 p-2">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" s
                                    placeholder="Batas Tanggal Pelamaran">
                            </div>

                            <div class="mb-4 p-2">
                                <label for="deskripsi_pekerjaan" class="form-label">Deskripsi Pekerjaan</label>
                                <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" cols="30" rows="10" class="form-control"></textarea>
                            </div>

                            <div class="row">
                                <button class="btn btn-primary col-6 offset-3" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        ClassicEditor
            .create( document.querySelector( '#deskripsi_pekerjaan' ) )
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
        } );
            
    </script>
@endpush
