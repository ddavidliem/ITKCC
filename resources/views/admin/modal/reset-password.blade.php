<div class="modal  fade" id="resetPassword" tabindex="-1">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Reset Password Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="{{ Route('admin.reset-password') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Password Lama</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Password Baru</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="confirm_password" required>
                    </div>
                    <div class="my-4">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-dark">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
