<div class="modal fade" id="newAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Membuat Appointment Konseling Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ Route('admin.appointment.new', ['id' => $user->id]) }}"
                    class="form-validate" novalidate>
                    @csrf
                    <div class="my-2">
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
                        <select id="" class="form-select" name="tempat_konseling" required>
                            <option value="" selected disabled>Pilih Tempat Konseling</option>
                            <option value="Online">Online, Google Meet, Zoom</option>
                            <option value="Offline">Offline, LPPM ITK</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="tanggal_konseling" class="form-label fw-semibold">Tanggal Konsultasi</label>
                        <input type="date" class="form-control" id="" name="tanggal_konseling"
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
                        <button class="btn btn-outline-dark px-5">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
