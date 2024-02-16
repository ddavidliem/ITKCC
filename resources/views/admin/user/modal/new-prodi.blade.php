<div class="modal fade" id="newProdi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Penambahan Program Studi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ Route('admin.prodi.new') }}" class="form-validate" novalidate>
                    @csrf
                    <div class="my-2">
                        <label for="" class="fw-semibold form-label">Program Studi</label>
                        <input type="text" class="form-control" name="program_studi" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="fw-semibold form-label">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" required>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
