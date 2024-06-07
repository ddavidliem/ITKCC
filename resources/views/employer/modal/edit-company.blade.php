<div class="modal fade" id="editCompany" tabindex="-1" aria-labelledby="editCompany" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Mengubah Data Perusahaan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('employer.profile.company.update') }}" method="post" class="form-validate"
                    novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan"
                            class="form-control @error('nama_perusahaan') is-invalid @enderror"
                            value="{{ $employer->nama_perusahaan }}" required>
                        @error('nama_perusahaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Bidang Perusahaan</label>
                        <input type="text" name="bidang_perusahaan"
                            class="form-control @error('bidang_perusahaan') is-invalid @enderror"
                            value="{{ $employer->bidang_perusahaan }}" required>
                        @error('bidang_perusahaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Website</label>
                        <input type="text" name="website" class="form-control @error('website') is-invalid @enderror"
                            value="{{ $employer->website }}" required>
                        @error('website')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tahun Berdiri</label>
                        <input type="text" name="tahun_berdiri"
                            class="form-control @error('tahun_berdiri') is-invalid @enderror"
                            value="{{ $employer->tahun_berdiri }}" required>
                        @error('tahun_berdiri')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kantor Pusat</label>
                        <input type="text" name="kantor_pusat"
                            class="form-control @error('kantor_pusat') is-invalid @enderror"
                            value="{{ $employer->kantor_pusat }}" required>
                        @error('kantor_pusat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kota</label>
                        <input type="text" name="kota" class="form-control @error('kota') is-invalid @enderror"
                            value="{{ $employer->kota }}" required>
                        @error('kota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror "
                            value="{{ $employer->alamat }}" required>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Provinsi</label>
                        <input type="text" name="provinsi"
                            class="form-control @error('provinsi') is-invalid @enderror"
                            value="{{ $employer->provinsi }}" required>
                        @error('provinsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" name="kode_pos"
                            class="form-control @error('kode_pos') is-invalid @enderror"
                            value="{{ $employer->kode_pos }}" required>
                        @error('kode_pos')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@if (session('modal') === 'editCompany')
    @push('script')
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {
                var modalID = '{{ session('modal') }}';
                var myModal = new bootstrap.Modal(document.getElementById(modalID));
                myModal.show();
                @php session()->forget('modal'); @endphp
            });
        </script>
    @endpush
@endif
