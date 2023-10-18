<div class="modal  fade" id="editCarouselModal" tabindex="-1" aria-labelledby="editCarouselModal" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Carousel Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form class="needs-validation" action="/contents/carousel/{{ $carousel->id }}/update" method="post"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="my-4">
                        <div class="my-3">
                            <label for="carouselTitle" class="form-label fw-semibold">Title</label>
                            <input type="text" class="form-control" name="carouselTitle"
                                value="{{ $carousel->title }}" required>
                        </div>
                        <div class="my-3">
                            <label for="carouselCaption" class="form-label fw-semibold">Caption</label>
                            <input type="text" class="form-control" name="carouselCaption"
                                value="{{ $carousel->body }}">
                            <div class="form-text">
                                Caption dari carousel dapat dikosongkan.
                            </div>
                        </div>
                        <div class="my-3">
                            <input type="checkbox" class="form-check-input modal-checkbox" name="carouselStatus"
                                {{ $carousel->status == true ? 'checked' : '' }}>
                            <label for="carouselStatus" class="form-label fw-semibold">Aktifkan Carousel</label>
                            <div class="form-text">Centang Untuk Menampilan Carousel Pada Halaman Utama</div>
                        </div>
                        <div class="my-3">
                            <label for="carouselImage" class="form-label fw-semibold">Carousel</label>
                            <input type="file" class="form-control" name="carouselImage">
                            <div class="form-text">
                                Gambar dapat dikosongkan
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-outline-dark">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
