<div class="modal fade" id="responseAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Konfirmasi Appointment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" id="responseAppointmentForm" class="form-validate" novalidate>
                    @csrf
                    @method('Put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status Appointment</label>
                        <select name="status" id="" class="form-select">
                            <option value="" disabled selected>Pilih Status Appointment</option>
                            <option value="finished">Finished</option>
                            <option value="accepted">Accepted</option>
                            <option value="reschedule">Reschedule</option>
                            <option value="declined">Decline</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Feedback</label>
                        <textarea name="feedback" class="form-control"></textarea>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
