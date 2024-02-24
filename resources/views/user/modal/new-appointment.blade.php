<div class="modal fade appointment" id="newAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Buat Appointment Konseling</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ Route('user.appointment.create') }}" method="POST" class="form-validate" novalidate>
                @csrf
                <div class="modal-body min-vh-50 scroll-modal p-4">
                    <div>
                        <label for="topik" class=" form-label fw-semibold">Topik Konseling</label>
                        <select class="form-select" name="topik" id="" required>
                            <option value="" disabled selected>Pilih Topik Konseling</option>
                            @foreach ($topik as $item)
                                <option value="{{ $item->topik }}">{{ $item->topik }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="jenis_konsultasi" class="form-label fw-semibold">Jenis Konseling</label>
                        <select name="jenis_konseling" class="form-select" id="" required>
                            <option value="" disabled selected>Jenis Konseling</option>
                            <option value="individu">Individu (Pribadi)</option>
                            <option value="kelompok">Kelompok</option>
                        </select>
                        <div class="form-text">
                            Jika peserta konseling kelompok lebih dari 5 Orang disarankan konseling secara online
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="tempat_konseling" class="form-label fw-semibold">Tempat Konseling</label>
                        <select class="form-select tempat_konseling" name="tempat_konseling" required>
                            <option value="" selected disabled>Pilih Tempat Konseling</option>
                            <option value="Online">Online, Google Meet, Zoom</option>
                            <option value="Offline">Offline, LPPM ITK</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Link Google Meet</label>
                        <input type="text" class="form-control" id="google_meet" name="google_meet" required>
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
