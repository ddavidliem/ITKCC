<div class="modal  fade" id="addTopic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Tambah Topik Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="{{ Route('admin.appointment.topik.new') }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Topik Konseling</label>
                        <input type="text" class="form-control" name="topik" required>
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
