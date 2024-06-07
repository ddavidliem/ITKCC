<div class="modal fade" id="editLoker" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Detail Lowongan Kerja</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ Route('admin.loker.update', ['id' => $loker->id]) }}"
                    class="form-validate" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Lowongan Kerja</label>
                        <input type="text" name="nama_pekerjaan"
                            class="form-control @error('nama_pekerjaan') is-invalid @enderror"
                            value="{{ $loker->nama_pekerjaan }}" required>
                        @error('nama_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="jenis_pekerjaan" class="form-label fw-semibold">Jenis Pekerjaan</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan"
                            class="form-select @error('jenis_pekerjaan') is-invalid @enderror" required>
                            <option value="Full Time" @if ($loker->jenis_pekerjaan === 'Full Time') selected @endif>Full Time
                            </option>
                            <option value="Part Time" @if ($loker->jenis_pekerjaan === 'Part Time') selected @endif>Part Time
                            </option>
                            <option value="Contract" @if ($loker->jenis_pekerjaan === 'Contract') selected @endif>Contract</option>
                            <option value="Volunteer"@if ($loker->jenis_pekerjaan === 'Volunteer') selected @endif>Volunteer
                            </option>
                            <option value="Internship"@if ($loker->jenis_pekerjaan === 'Internship') selected @endif>Internship
                            </option>
                            <option value="Other"@if ($loker->jenis_pekerjaan === 'Other') selected @endif>Other</option>
                        </select>
                        @error('jenis_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="tipe_pekerjaan" class="form-label fw-semibold">Tipe Pekerjaan</label>
                        <select name="tipe_pekerjaan" id="tipe_pekerjaan"
                            class="form-select @error('tipe_pekerjaan') is-invalid @enderror" required>
                            <option value="" selected disabled>Pilih Tipe Pekerjaan</option>
                            <option value="WFO" @if ($loker->tipe_pekerjaan === 'WFO') selected @endif>WFO</option>
                            <option value="WFH" @if ($loker->tipe_pekerjaan === 'WFH') selected @endif>WFH</option>
                            <option value="Hybrid" @if ($loker->tipe_pekerjaan === 'Hybrid') selected @endif>Hybrid</option>
                        </select>
                        @error('tipe_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="lokasi_pekerjaan" class="form-label fw-semibold">Lokasi</label>
                        <input type="text" name="lokasi_pekerjaan" value="{{ $loker->lokasi_pekerjaan }}"
                            class="form-control @error('lokasi_pekerjaan') is-invalid @enderror" required>
                        @error('lokasi_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="deadline" class="form-label fw-semibold">Deadline</label>
                        <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                            value="{{ $loker->deadline->format('Y-m-d') }}" name="deadline" required>
                        @error('deadline')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="deskripsi_pekerjaan" class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                        <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" cols="30" rows="10"
                            class="form-control @error('deskripsi_pekerjaan') is-invalid @enderror" required>{{ $loker->deskripsi_pekerjaan }}</textarea>
                        @error('deskripsi_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status Lowongan Kerja</label>
                        <select name="status_pekerjaan"
                            class="form-select status-select @error('status_pekerjaan') is-invalid @enderror">
                            <option value="Open" {{ $loker->status == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ $loker->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="Suspended" {{ $loker->status == 'Suspended' ? 'selected' : '' }}>Suspended
                            </option>
                        </select>
                        <div class="form-text">
                            Berhati-hati untuk mengubah status lowongan kerja
                        </div>
                        @error('status_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-none my-2" id="loker_suspend_note">
                        <label for="" class="form-label fw-semibold">Alasan Suspend</label>
                        <textarea name="feedback_status_pekerjaan"
                            class="form-control @error('feedback_status_pekerjaan') is-invalid @enderror" id="" cols="30"
                            rows="10" id="feedback_status_pekerjaan">{{ $loker->suspend_note }}</textarea>
                        @error('feedback_status_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="poster" class="form-label fw-semibold">Poster Lowongan Kerja</label>
                        <input type="file" class="form-control @error('poster') is-invalid @enderror"
                            name="poster">
                        <div class="form-text">
                            File Poster Maks 1mb, Format PNG
                        </div>
                        @error('poster')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@if (session('modal') === 'editLoker')
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
        const editLoker = document.getElementById('editLoker');
        editLoker.addEventListener('change', function() {
            const status = event.target;

            if (status.classList.contains('status-select')) {
                const suspend_note = editLoker.querySelector('#feedback_status_pekerjaan');
                const suspend_note_field = editLoker.querySelector('#loker_suspend_note');

                if (status.value == 'Suspended') {
                    suspend_note_field.classList.remove('d-none');
                    suspend_note.setAttribute('required', true);
                } else {
                    suspend_note_field.classList.add('d-none');
                    suspend_note.setAttribute('required', false);
                }
            }
        })
    </script>
@endpush
