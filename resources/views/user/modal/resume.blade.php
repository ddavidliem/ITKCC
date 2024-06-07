<div class="modal  fade" id="uploadResume" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">User Resume Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="{{ Route('user.profile.resume.update') }}" class="form-validate" method="POST"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-1">
                        <label for="resume" class="form-label fw-semibold">Resume</label>
                        <input type="file" class="form-control" id="resume" aria-describedby="resume"
                            aria-label="Upload" name="resume" required>
                        <div class="form-text">
                            Silahkan Mengupload Resume Terbaru Disini.
                        </div>
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
                <div class="my-2">
                    @if ($user->resume)
                        <iframe src="{{ asset('resume/' . $user->resume) }}" frameborder="0" class="my-4"
                            width="100%" height="700px"></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('modal') === 'uploadResume')
    @push('script')
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {
                var modalID = '{{ session('modal') }}';
                var myModal = new bootstrap.Modal(document.getElementById(modalID));
                myModal.show();
                @php session()->forget('modal'); @endphp
            });
        </script>
    @endpush
@endif
