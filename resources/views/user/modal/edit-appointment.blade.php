<div class="modal fade appointment" id="updateAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Perubahan jadwal Konseling</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="POST" class="form-validate" id="updateAppointmentForm" novalidate>
                @method('put')
                @csrf
                <div class="modal-body min-vh-50 scroll-modal p-4">
                    <div class="my-2">
                        <label for="tempat_konseling" class="form-label fw-semibold">Tempat Konseling</label>
                        <select id="tempat_konseling_edit"
                            class="form-select @error('tempat_konseling_edit') is-invalid @enderror"
                            name="tempat_konseling_edit" required>
                            <option value="" selected disabled>Pilih Tempat Konseling</option>
                            <option value="Online">Online, Google Meet, Zoom</option>
                            <option value="Offline">Offline, LPPM ITK</option>
                        </select>
                        @error('tempat_konseling_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Link Google Meet</label>
                        <input type="text" class="form-control @error('google_meet_edit') is-invalid @enderror"
                            id="google_meet_edit" name="google_meet_edit">
                        @error('google_meet_edit')
                            <div class="invalid-feedback">
                                {[$message]}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="tanggal_konseling" class="form-label fw-semibold">Tanggal Konsultasi</label>
                        <input type="date" class="form-control @error('tanggal_konseling_edit') is-invalid @enderror"
                            name="tanggal_konseling_edit" placeholder="Pilih Tanggal Konseling"
                            id="tanggal_konseling_edit" required>
                        <div class="form-text">
                            Coaching Clinic hanya menyediakan layanan di hari senin hingga jumat
                        </div>
                        @error('tanggal_konseling_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jam Konseling</label>
                        <select name="jam_konseling_edit"
                            class="form-select @error('jam_konseling_edit')is-invalid @enderror" id="jam_konseling_edit"
                            required>
                            <option value="" disabled selected>Pilih Jam Konseling</option>
                            <option value="09:00">09:00-10.00</option>
                            <option value="10:15">10:15-11.15</option>
                            <option value="13:00">13:00-14.00</option>
                            <option value="14:15">14:15-15.30</option>
                        </select>
                        @error('jam_konseling_edit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if (session('modal') === 'updateAppointment')
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
