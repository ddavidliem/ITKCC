<div class="modal fade edit-appointment" id="editAppointment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#edit-form"
                            type="button" role="tab" aria-controls="form" aria-selected="true">Form Mengubah Data
                            Appointment</button>
                        <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#edit-calendar"
                            type="button" role="tab" aria-controls="calendar"
                            aria-selected="false">Calendar</button>
                    </div>
                </nav>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body min-vh-50 p-4">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="edit-form" role="tabpanel">
                        <form method="POST" id="editAppointmentForm" class="form-validate" novalidate>
                            @csrf
                            @method('put')
                            <div class="my-2">
                                <label for="topik" class=" form-label fw-semibold">Topik Konseling</label>
                                <select class="form-select @error('topik_konseling_edit') is-invalid @enderror"
                                    name="topik_konseling_edit" id="topik" required>
                                    @foreach ($topik as $item)
                                        <option value="{{ $item->topik }}">{{ $item->topik }}</option>
                                    @endforeach
                                </select>
                                @error('topik_konseling_edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="my-2">
                                <label for="jenis_konseling_edit" class="form-label fw-semibold">Jenis Konseling</label>
                                <select name="jenis_konseling_edit"
                                    class="form-select jenis_konseling_edit @error('jenis_konseling_edit') is-invalid @enderror"
                                    id="jenis_konseling_edit" required>
                                    @foreach (['individu' => 'Individu (Pribadi)', 'kelompok' => 'Kelompok'] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    Jika peserta konseling kelompok lebih dari 5 Orang disarankan konseling secara
                                    online
                                </div>
                                @error('jenis_konseling_edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="my-2 d-none" id="jumlah_peserta_field_edit">
                                <label for="" class="form-label fw-semibold">Jumlah Peserta</label>
                                <select name="jumlah_peserta_konseling_edit"
                                    class="form-select jumlah_peserta @error('jumlah_peserta_konseling') is-invalid @enderror"
                                    id="select_jumlah_edit">
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
                                <select
                                    class="form-select tempat_konseling_edit @error('tempat_konseling_edit') is-invalid @enderror"
                                    id="tempat_konseling_edit" name="tempat_konseling_edit" required>
                                    @foreach (['Online' => 'Online', 'Offline' => 'Offline'] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('tempat_konseling_edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="my-2">
                                <label for="" class="form-label fw-semibold">Link Google Meet</label>
                                <input type="text"
                                    class="form-control @error('google_meet_edit') is-invalid @enderror"
                                    id="google_meet_edit" name="google_meet_edit" required>
                                <div class="form-text">
                                    contoh url : https://meet.google.com/abc-defg-hij
                                </div>
                                @error('google_meet_edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @if (session('filled'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('filled') }}
                                </div>
                            @endif
                            <div class="my-2">
                                <label for="tanggal_konseling" class="form-label fw-semibold">Tanggal Konsultasi</label>
                                <input type="date"
                                    class="form-control @error('tanggal_konseling_edit') is-invalid @enderror"
                                    id="tanggal_konseling" name="tanggal_konseling_edit"
                                    placeholder="Pilih Tanggal Konseling" required>
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
                                <select name="jam_konseling_edit" id="jam_konseling"
                                    class="form-select @error('jam_konseling_edit') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Jam Konseling</option>
                                    <option value="09:00">09.00</option>
                                    <option value="10:15">10.15</option>
                                    <option value="13:00">13.00</option>
                                    <option value="14:15">14.15</option>
                                </select>
                                @error('jam_konseling_edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="my-3 d-flex justify-content-end">
                                <button class="btn btn-outline-dark px-5">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="edit-calendar" role="tabpanel">
                        <div id="calendar-modal-edit" class="min-vh-75 overflow-auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('modal') === 'editAppointment')
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
            const editCalendar = new Calendar(document.getElementById('calendar-modal-edit'), {
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
            editCalendar.render();

        });
    </script>
@endpush
