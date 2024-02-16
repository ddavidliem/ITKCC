<div class="modal  fade" id="updateProfileImg" tabindex="-1" aria-labelledby="profileImgModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Form Profile Picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ Route('user.profile.image.update') }}" class="form-validate" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="profile_img" class="form-label fw-semibold">Foto Profile</label>
                        <input type="file" class="form-control" id="profile_img" aria-describedby="profile_img"
                            aria-label="Upload" name="profile_img" required>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
