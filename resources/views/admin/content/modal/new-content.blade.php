<div class="modal fade" id="newContent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Menambah Konten Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <h5 class="fw-bold">Form Menambah Konten Baru</h5>
                <form method="POST" action="{{ Route('admin.contents.create') }}" id="newContentForm"
                    class="form-validate" novalidate>
                    @csrf
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kategori</label>
                        <select name="category" id="content_category" class="form-select" required>
                            <option value="" disabled selected>Pilih Kategori
                            </option>
                            <option value="Carousel">Carousel
                            </option>
                            <option value="Berita">Berita</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Image</label>
                        <input type="file" class="form-control" name="img_content" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" name="title_content" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Body</label>
                        <textarea name="body_content" id="body-input" class="form-control"></textarea>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Tambah Konten</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
