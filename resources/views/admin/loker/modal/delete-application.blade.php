<div class="modal fade" id="deleteApplication" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Konfirmasi Penghapusan Lamaran Kerja</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <h5 class="fw-bold">Konfirmasi Penghapusan Lamaran Kerja <span>{{ $loker->nama_pekerjaan }},
                        {{ $loker->employer->nama_perusahaan }}</span>
                </h5>
                <form method="POST" id="deleteApplicationForm" class="form-validate" novalidate>
                    @csrf
                    @method('Delete')
                    <div class="my-2">
                        <div class="form-text">
                            Penghapusan Lamaran Kerja
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
