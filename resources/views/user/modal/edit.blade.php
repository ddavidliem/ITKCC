<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Edit User Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="/update-user-data" method="POST" class="form-validate" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-3">
                        <label for="edit_nama" class="form-label fw-semibold">Nama lengkap</label>
                        <input type="text" class="form-control" name="edit_nama" value="{{ $user->nama_lengkap }}"
                            required>
                    </div>
                    <div class="my-3">
                        <label for="edit_email" class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" class="form-control" name="edit_email" value="{{ $user->alamat_email }}"
                            required>
                    </div>
                    <div class="my-3">
                        <label for="edit_nomorTelepon" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control" name="edit_nomorTelepon"
                            value="{{ $user->nomor_telepon }}" required>
                    </div>
                    <div class="my-3">
                        <label for="edit_tempatLahir" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" class="form-control" name="edit_tempatLahir"
                            value="{{ $user->tempat_lahir }}" required>
                    </div>
                    <div class="my-3">
                        <label for="edit_tanggalLahir" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="edit_tanggalLahir"
                            value="{{ $user->tanggal_lahir }}" required>
                    </div>
                    <div class="my-3">
                        <label for="edit_alamat" class="form-label fw-semibold">Alamat</label>
                        <input type="text" class="form-control" name="edit_alamat" value="{{ $user->alamat }}"
                            required>
                    </div>
                    <div class="my-3">
                        <label for="edit_kota" class="form-label fw-semibold">Kota</label>
                        <input type="text" class="form-control" name="edit_kota" value="{{ $user->kota }}"
                            required>
                    </div>
                    <div class="my-4">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-dark">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
