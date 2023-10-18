<div class="modal  fade" id="editContentModal" tabindex="-1" aria-labelledby="editContentModal" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="editModal">Edit Content</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="/contents/{{ $content->id }}/update" class="needs-validation" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="my-3">
                        <label for="editTitle" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" value="{{ $content->title }}" name="editTitle"
                            required>
                    </div>
                    <div class="my-3">
                        <label for="editBody" class="form-label fw-semibold">Body</label>
                        <textarea name="editBody" class="form-control" required>{{ $content->body }}</textarea>
                    </div>
                    <div class="my-3">
                        <label for="editImage" class="form-label fw-semibold">Image</label>
                        <input type="file" class="form-control edit-image-content">
                        <div class="form-text" id="imageHelp">Upload Gambar Terbaru</div>
                    </div>
                    <div class="my-3">
                        <input type="checkbox" class="form-check-input modal-checkbox" name="deleteImage">
                        <label for="deleteImage" class="form-label fw-semibold">Hapus Gambar</label>
                        <div class="form-text">Centang Untuk Menghapus Gambar Konten</div>
                    </div>
                    <div class="my-3">
                        <input type="checkbox" class="form-check-input" name="editStatus"
                            {{ $content->status == true ? 'checked' : '' }}>
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
