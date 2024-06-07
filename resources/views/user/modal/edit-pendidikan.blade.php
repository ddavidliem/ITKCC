<div class="modal fade" id="editPendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Mengubah Data Pendidikan</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <form method="post" class="form-validate" id="editPendidikanForm" novalidate>
                @csrf
                @method('put')
                <div class="modal-body min-vh-75 scroll-modal p-4">
                    <div class="mb-3">
                        <label for="" class="form-label fw-semibold">Nama Sekolah</label>
                        <input type="text" class="form-control @error('nama_sekolah_edit') is-invalid @enderror"
                            id="nama_sekolah" name="nama_sekolah_edit"
                            @error('nama_sekolah_edit')value="{{ old('nama_sekolah_edit') }}" @enderror required
                            autofocus>
                        @error('nama_sekolah_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Bidang Studi</label>
                        <input type="text" class="form-control @error('bidang_studi_edit') is-invalid @enderror"
                            id="bidang_studi" required name="bidang_studi_edit"
                            @error('bidang_studi_edit')
                                value="{{ old('bidang_studi_edit') }}"
                            @enderror>
                        @error('bidang_studi_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Tahun Lulus</label>
                        <div class="">
                            <select name="tahun_lulus_edit"
                                class="form-select @error('tahun_lulus_edit') is-invalid @enderror" id="tahun_lulus">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('tahun_lulus_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Tingkat Pendidikan</label>
                        <select name="tingkat_pendidikan_edit"
                            class="form-select @error('tingkat_pendidikan') is-invalid @enderror"
                            id="tingkat_pendidikan" required>
                            <option value="Sekolah Menengah Atas">SMA</option>
                            <option value="Diploma-1">Diploma-1</option>
                            <option value="Diploma-2">Diploma-2</option>
                            <option value="Diploma-3">Diploma-3</option>
                            <option value="Strata-1">Strata-1</option>
                            <option value="Strata-2">Strata-2</option>
                            <option value="Strata-3">Strata-3</option>
                        </select>
                        @error('tingkat_pendidikan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Alamat Sekolah</label>
                        <textarea class="form-control @error('alamat_sekolah_edit') is-invalid @enderror" name="alamat_sekolah_edit"
                            id="alamat_sekolah" cols="30" rows="5">
                            @error('alamat_sekolah_edit')
{{ old('alamat_sekolah_edit') }}
@enderror
                        </textarea>
                        @error('alamat_sekolah_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Keterangan</label>
                        <textarea class="form-control @error('keterangan_pendidikan_edit') is-invalid @enderror"
                            name="keterangan_pendidikan_edit" id="keterangan" cols="30" rows="10"></textarea>
                        @error('keterangan_pendidikan_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@if (session('modal') === 'editPendidikan')
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
