<div class="modal fade appointment" id="newAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#new-form"
                            type="button" role="tab" aria-controls="form" aria-selected="true">Form Menambah
                            Appointment</button>
                        <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#new-calendar"
                            type="button" role="tab" aria-controls="calendar"
                            aria-selected="false">Calendar</button>
                    </div>
                </nav>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="new-form" role="tabpanel">
                        <form method="POST" action="{{ Route('admin.appointment.new', ['id' => $user->id]) }}"
                            class="form-validate" novalidate>
                            @csrf
                            <div class="my-2">
                                <label for="topik" class=" form-label fw-semibold">Topik Konseling</label>
                                <select class="form-select " name="topik_konseling" required>
                                    <option value="" disabled selected>Pilih Topik Konseling</option>
                                    @foreach ($topik as $item)
                                        <option value="{{ $item->topik }}">{{ $item->topik }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="my-2">
                                <label for="jenis_konsultasi" class="form-label fw-semibold">Jenis Konseling</label>
                                <select name="jenis_konseling" class="form-select jenis_konseling_new " required>
                                    <option value="" disabled selected>Jenis Konseling</option>
                                    <option value="individu">Individu (Pribadi)</option>
                                    <option value="kelompok">Kelompok</option>
                                </select>
                                <div class="form-text">
                                    Jika peserta konseling kelompok lebih dari 3 Orang disarankan konseling secara
                                    online
                                </div>
                            </div>
                            <div class="my-2 d-none" id="jumlah_peserta_field_new">
                                <label for="" class="form-label fw-semibold">Jumlah Peserta</label>
                                <select name="jumlah_peserta_konseling"
                                    class="form-select jumlah_peserta @error('jumlah_peserta_konseling') is-invalid @enderror"
                                    id="select_jumlah_new">
                                    <option value="" selected disabled>Pilih Jumlah Peserta</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <div class="form-text">
                                    Jumlah Maksimal Peserta Konseling 5
                                </div>
                                @error('jumlah_peserta_konseling')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                <input type="text" class="form-control" id="google_meet_new" name="google_meet"
                                    required>
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
                                <select name="jam_konseling" class="form-select" required>
                                    <option value="" disabled selected>Pilih Jam Konseling</option>
                                    <option value="09:00">09.00-10.00</option>
                                    <option value="10:15">10.15-11.15</option>
                                    <option value="13:00">13.00-14.00</option>
                                    <option value="14:15">14.15-15.30</option>
                                </select>
                            </div>
                            <div class="my-3 d-flex justify-content-end">
                                <button class="btn btn-outline-dark px-5">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="new-calendar" role="tabpanel">
                        <div id="calendar-modal" class="min-vh-75 overflow-auto"></div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

@if (session('modal') === 'newAppointment')
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

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const event = @json($appointment);
            const eventArray = event.map(event => ({
                title: 'Reserved',
                start: event.date_time,
            }));
            const calendar = new Calendar(document.getElementById('calendar-modal'), {
                plugins: [timegrid, list, fullCalendarStyle],
                initialView: 'timeGridDay',
                headerToolbar: {
                    left: 'prev,next,today',
                    center: '',
                    right: 'timeGridWeek,timeGridDay,listWeek',
                },
                themeSystem: 'bootstrap5',
                businessHours: {
                    startTime: '08:00',
                    endTime: '16:00',
                },
                weekends: false,
                slotMinTime: '08:00:00',
                slotMaxTime: '16:00:00',
                events: eventArray,
            });
            calendar.render();

        });
    </script>
@endpush
