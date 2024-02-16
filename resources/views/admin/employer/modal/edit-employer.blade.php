<div class="modal fade" id="editEmployer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Mengubah Data Perusahaan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4 max-vh-75 overflow-auto">
                <h5 class="fw-bold">Mengubah Data Perusahaan</h5>
                <form method="POST" action="{{ Route('admin.employer.edit', ['id' => $employer->id]) }}">
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan"
                            value="{{ $employer->nama_perusahaan }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="{{ $employer->alamat }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kota</label>
                        <input type="text" class="form-control" name="kota" value="{{ $employer->kota }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Provinsi</label>
                        <input type="text" class="form-control" name="provinsi" value="{{ $employer->provinsi }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kantor Pusat</label>
                        <input type="text" class="form-control" name="kantor_pusat"
                            value="{{ $employer->kantor_pusat }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">website</label>
                        <input type="text" class="form-control" name="website" value="{{ $employer->website }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Bidang Perusahaan</label>
                        <input type="text" class="form-control" name="bidang_perusahaan"
                            value="{{ $employer->bidang_perusahaan }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tahun Berdiri</label>
                        <input type="text" class="form-control" name="tahun_berdiri"
                            value="{{ $employer->tahun_berdiri }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" class="form-control" name="kode_pos" value="{{ $employer->kode_pos }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Employer</label>
                        <input type="text" class="form-control" name="nama_employer"
                            value="{{ $employer->nama_lengkap }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control" name="nomor_telepon"
                            value="{{ $employer->nomor_telepon }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat Email</label>
                        <input type="text" class="form-control" name="alamat_email"
                            value="{{ $employer->alamat_email }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" value="{{ $employer->jabatan }}"
                            required>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
