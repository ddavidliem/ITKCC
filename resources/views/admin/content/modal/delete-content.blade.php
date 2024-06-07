    <div class="modal  fade" id="deleteContent" tabindex="-1" aria-labelledby="deleteContentModal" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="deleteModal">Delete Content</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
                </div>
                <div class="p-4">
                    <form method="POST" id="deleteForm" novalidate>
                        @csrf
                        @method('Delete')
                        <div class="my-3">
                            <h6>Konfirmasi Untuk Menghapus Konten <span id="deleteTarget"></span></h6>
                        </div>
                        <div class="my-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-dark">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
