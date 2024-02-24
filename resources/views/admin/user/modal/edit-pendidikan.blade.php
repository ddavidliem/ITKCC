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
                        <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" required
                            autofocus>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Bidang Studi</label>
                        <input type="text" class="form-control" id="bidang_studi" required name="bidang_studi">
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Tahun Lulus</label>
                        <div class="">
                            <input type="text" id="tahun_lulus" name="tahun_lulus" class="form-control"
                                min="1990" max="{{ date('Y') }}" required>
                        </div>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Tingkat Pendidikan</label>
                        <select name="tingkat_pendidikan" class="form-select" id="tingkat_pendidikan" required>
                            <option value="Sekolah Menengah Atas">SMA</option>
                            <option value="Diploma-1">Diploma-1</option>
                            <option value="Diploma-2">Diploma-2</option>
                            <option value="Diploma-3">Diploma-3</option>
                            <option value="Strata-1">Strata-1</option>
                            <option value="Strata-2">Strata-2</option>
                            <option value="Strata-3">Strata-3</option>
                        </select>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Alamat Sekolah</label>
                        <textarea class="form-control" name="alamat_sekolah" id="alamat_sekolah" cols="30" rows="5"></textarea>
                    </div>

                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
                    </div>

                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
