<div class="modal fade" id="statusApplication" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Application Status Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" id="statusForm" class="form-validate" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status</label>
                        <select name="application_status" id="" class="form-select" required>
                            <option value="" disabled selected>Select Status
                            </option>
                            <option value="accepted">Accepted
                            </option>
                            <option value="declined">Declined</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Feedback</label>
                        <textarea class="form-control" name="application_feedback" id="" cols="30" rows="10"></textarea>
                        <div class="form-text">
                            Feedback Dapat Dikosongkan
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
