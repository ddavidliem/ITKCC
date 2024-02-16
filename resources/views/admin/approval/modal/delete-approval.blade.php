<div class="modal fade" id="deleteApprovalModal" tabindex="-1" aria-labelledby="deleteApprovalModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Delete Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <h5 class="fw-bold">Konfirmasi Penghapusan Approval Akun Perusahaan</h5>
                <h6 id="approvalDelete" class="fw-semibold text-capitalize"></h6>
                <form method="POST" id="deleteForm" class="form-validate" novalidate>
                    @csrf
                    @method('Delete')
                    <div class="my-2">
                        Konfirmasi Penghapusan Approval Akun Perusahaan
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
