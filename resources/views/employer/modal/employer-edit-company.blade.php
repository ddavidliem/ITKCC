<div class="modal fade" id="editCompany" tabindex="-1" aria-labelledby="editCompany" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Edit Company Information Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form action="/update-company" method="post" class="form-validate" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan" class="form-control"
                            value="{{ $employer->nama_perusahaan }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Website</label>
                        <input type="text" name="website" class="form-control" value="{{ $employer->website }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tahun Berdiri</label>
                        <input type="text" name="tahun_berdiri" class="form-control"
                            value="{{ $employer->tahun_berdiri }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kantor Pusat</label>
                        <input type="text" name="kantor_pusat" class="form-control"
                            value="{{ $employer->kantor_pusat }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kota</label>
                        <input type="text" name="kota" class="form-control" value="{{ $employer->kota }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat</label>
                        <input type="text" name="alamat" class="form-control" value="{{ $employer->alamat }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Provinsi</label>
                        <input type="text" name="provinsi" class="form-control" value="{{ $employer->provinsi }}"
                            required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" value="{{ $employer->kode_pos }}"
                            required>
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
