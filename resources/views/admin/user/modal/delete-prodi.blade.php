<div class="modal fade" id="deleteProdi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Konfirmasi Penghapusan Program Studi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" id="deleteProdiForm" class="form-validate" novalidate>
                    @csrf
                    @method('Delete')
                    <div class="my-2">
                        <h6>Konfirmasi Untuk Menghapus Program Studi ?</h6>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
