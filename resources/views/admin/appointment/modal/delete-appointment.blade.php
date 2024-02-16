<div class="modal fade" id="deleteAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Konfirmasi Penghapusan Appointment Konseling Karir</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" id="deleteAppointmentForm" class="form-validate" novalidate>
                    @csrf
                    @method('Delete')
                    <h6 class="fw-semibold">Konfirmasi Penghapusan <span id="delete-appointment-target"></span></h6>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
