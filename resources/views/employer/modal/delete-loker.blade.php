<div class="modal fade" id="deleteLoker" tabindex="-1" aria-labelledby="deleteLokerModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Delete Loker Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">

                <form action="/update-loker/{{ $loker->id }}" class="form-validate" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('delete')
                    <div class="my-4">
                        <h6 class="fw-semibold">Konfirmasi Untuk Menghapus Loker {{ $loker->nama_pekerjaan }}</h6>
                        <div class="form-text">
                            Menghapus Lowongan Kerja Ini Akan Menghapus Applications Yang Telah Dimasukkan Oleh User
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-danger">Confirm</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
