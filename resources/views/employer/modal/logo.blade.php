<div class="modal  fade" id="editLogo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Edit Logo Perusahaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('employer.profile.logo') }}" class="form-validate" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="profile_img" class="form-label fw-semibold">Logo Perusahaan</label>
                        <input type="file" class="form-control" name="logo_perusahaan" required>
                        <div class="form-text">
                            Gambar Logo Perusahaan Maks. 2MB, Rekomendasi Ukuran : 500x500. Format PNG.
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
