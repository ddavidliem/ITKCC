<div class="modal fade" id="uploadLogo" tabindex="-1" aria-labelledby="uploadLogo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Company Logo Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form action="/update-logo-company" method="POST" class="form-validate" enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Gambar Logo</label>
                        <input type="file" class="form-control" name="logo_perusahaan" required>
                        <div class="form-text">
                            Format Gambar PNG
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
