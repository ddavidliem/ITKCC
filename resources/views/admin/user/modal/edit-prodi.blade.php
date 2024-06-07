<div class="modal fade" id="editProdi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Mengubah Program Studi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" id="editProdiForm" class="form-validate" novalidate>
                    @csrf
                    @method('Put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Program Studi</label>
                        <input type="text" class="form-control @error('program_studi_edit') is-invalid @enderror"
                            name="program_studi_edit" id="prodi-input" required>
                        @error('program_studi_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jurusan</label>
                        <input type="text" class="form-control @error('jurusan_edit') is-invalid @enderror"
                            name="jurusan_edit" id="jurusan-input" required>
                        @error('jurusan_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Fakultas</label>
                        <input type="text" class="form-control @error('fakultas_edit') is-invalid @enderror"
                            name="fakultas_edit" id="fakultas-input">
                        @error('fakultas_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
