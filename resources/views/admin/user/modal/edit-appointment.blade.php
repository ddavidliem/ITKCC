<div class="modal fade appointment" id="editAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Form Mengubah Data Appointment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" id="editAppointmentForm" class="form-validate" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="topik" class=" form-label fw-semibold">Topik Konseling</label>
                        <select class="form-select" name="topik" id="topik" required>
                            @foreach ($topik as $item)
                                <option value="{{ $item->topik }}">{{ $item->topik }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="jenis_konsultasi" class="form-label fw-semibold">Jenis Konseling</label>
                        <select name="jenis_konseling" class="form-select" id="jenis_konseling" required>
                            @foreach (['individu' => 'Individu (Pribadi)', 'Kelompok' => 'Kelompok'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            Jika peserta konseling kelompok lebih dari 5 Orang disarankan konseling secara online
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="tempat_konseling" class="form-label fw-semibold">Tempat Konseling</label>
                        <select class="form-select tempat_konseling" name="tempat_konseling" required>
                            @foreach (['Online' => 'Online', 'Offline' => 'Offline'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Link Google Meet</label>
                        <input type="text" class="form-control" id="google_meet" name="google_meet" required>
                    </div>
                    <div class="my-2">
                        <label for="tanggal_konseling" class="form-label fw-semibold">Tanggal Konsultasi</label>
                        <input type="date" class="form-control" id="tanggal_konseling" name="tanggal_konseling"
                            placeholder="Pilih Tanggal Konseling" required>
                        <div class="form-text">
                            Coaching Clinic hanya menyediakan layanan di hari senin hingga jumat
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jam Konseling</label>
                        <select name="jam_konseling" id="jam_konseling" class="form-select" id="" required>
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
