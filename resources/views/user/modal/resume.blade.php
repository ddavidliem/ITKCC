<div class="modal  fade" id="uploadResumeModal" tabindex="-1" aria-labelledby="uploadResumeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">User Resume Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="/update-resume" method="POST" enctype="multipart/form-data" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('put')
                    <div class="my-1">
                        <label for="resume" class="form-label fw-semibold">Resume</label>
                        <input type="file" class="form-control" id="resume" aria-describedby="resume"
                            aria-label="Upload" name="resume" required>
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger mx-2"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
