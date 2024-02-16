<div class="modal  fade" id="editTopic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Mengubah Topik Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form method="POST" class="needs-validation" id="editTopicForm" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Topik Konseling</label>
                        <input type="text" class="form-control" id="edit-target" name="edit-topik" required>
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
