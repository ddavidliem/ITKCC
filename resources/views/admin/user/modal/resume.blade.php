<div class="modal fade" id="userResume" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Resume User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body min-vh-75 max-vh-75 overflow-auto p-4">
                <iframe src="{{ asset('resume/' . $user->resume) }}" frameborder="0"
                    style="width: 100%; height:100vh"></iframe>
            </div>
        </div>

    </div>

</div>
