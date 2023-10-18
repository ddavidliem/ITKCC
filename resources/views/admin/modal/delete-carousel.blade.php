<div class="modal  fade" id="deleteCarouselModal" tabindex="-1" aria-labelledby="deleteCarouselModal" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Delete Carousel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="/contents/carousel/{{ $carousel->id }}/delete" method="POST">
                    @csrf
                    @method('Delete')
                    <div class="my-3">
                        <h6>Konfirmasi Untuk Menghapus Carousel {{ $carousel->title }}</h6>
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Delete Content</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
