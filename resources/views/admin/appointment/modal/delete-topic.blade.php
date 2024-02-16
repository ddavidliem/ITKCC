<div class="modal  fade" id="deleteTopic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Menghapus Topik Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form method="POST" class="needs-validation" id="deleteTopicForm" novalidate>
                    @csrf
                    @method('delete')
                    <div class="my-3">
                        <h6 class="fw-semibold">Konfirmasi Penghapusan Topik Konseling Karir</h6>
                        <div class="form-text">
                            Penghapusan Topik <span id="delete-target"></span> Akan Menghapus Seluruh Appointment Yang
                            Memiliki Topik Ini
                        </div>
                    </div>
                    <div class="my-4">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-danger">Konfirmasi Penghapusan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
