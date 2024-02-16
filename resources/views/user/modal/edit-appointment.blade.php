<div class="modal fade" id="updateAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Perubahan jadwal Konseling</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="POST" class="form-validate" novalidate>
                @method('put')
                @csrf
                <div class="modal-body min-vh-50 scroll-modal p-4">
                    <div class="my-2">
                        <label for="tempat_konseling" class="form-label fw-semibold">Tempat Konseling</label>
                        <select id="" class="form-select" name="tempat_konseling" required>
                            <option value="" selected disabled>Pilih Tempat Konseling</option>
                            <option value="Online">Online, Google Meet, Zoom</option>
                            <option value="Offline">Offline, LPPM ITK</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="tanggal_konseling" class="form-label fw-semibold">Tanggal Konsultasi</label>
                        <input type="date" class="form-control" name="tanggal_konseling"
                            placeholder="Pilih Tanggal Konseling" required>
                        <div class="form-text">
                            Coaching Clinic hanya menyediakan layanan di hari senin hingga jumat
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jam Konseling</label>
                        <select name="jam_konseling" id="" class="form-select" id="" required>
                            <option value="" disabled selected>Pilih Jam Konseling</option>
                            <option value="09:00">09.00</option>
                            <option value="10:00">10.00</option>
                            <option value="11:00">11.00</option>
                            <option value="12:00">12.00</option>
                            <option value="13:00">13.00</option>
                            <option value="14:00">14.00</option>
                        </select>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
