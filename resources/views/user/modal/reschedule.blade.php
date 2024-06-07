<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-semibold" id="rescheduleModal">Formulir Perubahan Jadwal Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/edit-appointment/{{ $appointment->id }}" class="form-validate" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="my-3 col-10 offset-1">
                    <div class="my-4">
                        <label for="tempat_konseling_edit" class="form-label fw-semibold">Tempat Konseling</label>
                        <select id="" class="form-select" name="tempat_konseling_edit" required>
                            <option value="" selected disabled>Pilih Tempat Konseling</option>
                            <option value="Online">Online, Google Meet, Zoom</option>
                            <option value="Offline">Offline, LPPM ITK</option>
                        </select>
                    </div>
                    <div class="my-4">
                        <label for="tanggal_konseling_edit" class="form-label fw-semibold">Tanggal Konsultasi</label>
                        <input type="date" class="form-control" id="datepicker" name="tanggal_konseling_edit"
                            placeholder="Pilih Tanggal Konseling" required>
                        <div class="form-text">
                            Coaching Clinic hanya menyediakan layanan di hari senin hingga jumat
                        </div>
                    </div>
                    <div class="my-4">
                        <label for="" class="form-label fw-semibold">Jam Konseling</label>
                        <select name="jam_konseling_edit" id="" class="form-select" id="" required>
                            <option value="" disabled selected>Pilih Jam Konseling</option>
                            <option value="09:00">09.00</option>
                            <option value="10:00">10.00</option>
                            <option value="11:00">11.00</option>
                            <option value="12:00">12.00</option>
                            <option value="13:00">13.00</option>
                            <option value="14:00">14.00</option>
                        </select>
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button class="btn btn-outline-dark px-5">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if (session('modal') === 'rescheduleModal')
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
