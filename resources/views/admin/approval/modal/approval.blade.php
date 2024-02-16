<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Respon Approval Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <h5 class="fw-bold">Permohonan Pendaftaran Perusahaan</h5>
                <h6 id="approvalRespon" class="fw-semibold text-capitalize"></h6>
                <form method="POST" id="statusForm" class="form-validate" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status</label>
                        <select name="approval_status" id="" class="form-select" required>
                            <option value="" disabled selected>Select Status
                            </option>
                            <option value="accepted">Accept
                            </option>
                            <option value="declined">Decline</option>
                        </select>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
