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
                        <input type="text" class="form-control" name="program_studi" id="prodi-input" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan-input" required>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
