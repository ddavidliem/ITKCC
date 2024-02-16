<div class="modal fade" id="deletePengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Konfirmasi Penghapusan Pengalaman</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body p-4">
                <form method="post" class="form-validate" id="deletePengalamanForm" novalidate>
                    @csrf
                    @method('delete')
                    <div class="my-2">
                        <h6 class="fw-semibold">Konfirmasi Penghapusan Pengalaman</h6>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
