<div class="modal fade" id="deleteUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Menghapus User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ Route('admin.user.delete', ['id' => $user->id]) }}"
                    class="form-validate" id="deleteUserForm" novalidate>
                    @csrf
                    @method('Delete')
                    <div class="my-2">
                        <h6 class="fw-semibold">Konfirmasi Penghapusan User</h6>
                        <div class="form-text">
                            Penghapusan User Akan Menghapus Seluruh Data Yang Terkait Dengan User
                            {{ $user->nama_lengkap }}
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
