<div class="modal  fade" id="newCarouselForm" tabindex="-1" aria-labelledby="newCarouselForm" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">New Carousel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="/contents/carousel/new" method="POST" class="needs-validation"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="my-3">
                        <label for="carouselTitle" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" name="carouselTitle" required>
                    </div>
                    <div class="my-3">
                        <label for="carouselCaption" class="form-label fw-semibold">Caption</label>
                        <input type="text" class="form-control" name="carouselCaption">
                        <div class="form-text">
                            Caption dari carousel dapat dikosongkan.
                        </div>
                    </div>
                    <div class="my-3">
                        <label for="carouselImage" class="form-label fw-semibold">Carousel</label>
                        <input type="file" class="form-control" name="carouselImage" required>
                        <div class="form-text">
                            Disarankan menggunakan Layout 1440 x 600 PX
                        </div>
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
