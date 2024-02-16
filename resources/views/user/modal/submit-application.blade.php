<div class="modal fade" id="submitApplication" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Konfirmasi Memasukkan Lamaran</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body p-4">
                <form method="post" class="form-validate"
                    action="{{ Route('user.application.submit', ['id' => $loker->id]) }}" novalidate>
                    @csrf
                    <div class="my-2">
                        <h6 class="fw-semibold">Konfirmasi Untuk Memasukkan Lamaran</h6>
                        <div class="form-text">
                            Tolong Untuk Memastikan Resume, Data Diri Sudah Lengkap Dengan Benar.
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
