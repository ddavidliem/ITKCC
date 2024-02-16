<div class="modal  fade" id="editContent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="editModal">Mengubah Konten</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form class="needs-validation" method="POST" enctype="multipart/form-data" id="editForm" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Kategori</label>
                        <input type="text" name="category" class="form-control" id="edit_category" readonly>
                    </div>
                    <div class="my-3">
                        <label for="editTitle" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="editTitle">
                    </div>
                    <div class="my-3">
                        <label for="editBody" class="form-label fw-semibold">Body</label>
                        <textarea name="editBody" id="editBody" class="form-control"></textarea>
                    </div>
                    <div class="my-3">
                        <label for="editImage" class="form-label fw-semibold">Image</label>
                        <input type="file" name="edit_image" class="form-control edit-image-content">
                        <div class="form-text" id="imageHelp">Upload Gambar Terbaru</div>
                    </div>
                    <div class="my-3">
                        <input type="checkbox" class="form-check-input modal-checkbox" name="deleteImage">
                        <label for="deleteImage" class="form-label fw-semibold">Hapus Gambar</label>
                        <div class="form-text">Centang Untuk Menghapus Gambar Konten</div>
                    </div>
                    <div class="my-3">
                        <input type="checkbox" class="form-check-input" name="editStatus" {{-- {{ $content->status == true ? 'checked' : '' }} --}}>
                        <label for="editStatus" class="form-label fw-semibold">Tampilkan</label>
                        <div class="form-text">Centang untuk menampilkan konten</div>
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update Content</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
