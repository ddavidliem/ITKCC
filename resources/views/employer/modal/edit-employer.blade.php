<div class="modal fade" id="editEmployer" tabindex="-1" aria-labelledby="editEmployer" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Edit Employer Information Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ Route('employer.profile.update') }}" method="post" class="form-validate" novalidate>
                    @csrf
                    @method('put')
                    <div class="">
                        <label for="" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap"
                            value="{{ $employer->nama_lengkap }}">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" value="{{ $employer->jabatan }}">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control" name="nomor_telepon"
                            value="{{ $employer->nomor_telepon }}">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Email</label>
                        <input type="text" class="form-control" name="alamat_email"
                            value="{{ $employer->alamat_email }}">
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
