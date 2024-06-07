<div class="modal fade" id="editEmployer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Mengubah Data Perusahaan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4 max-vh-75 overflow-auto">
                <h5 class="fw-bold">Mengubah Data Perusahaan</h5>
                <form method="POST" action="{{ Route('admin.employer.edit', ['id' => $employer->id]) }}">
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Perusahaan</label>
                        <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror"
                            name="nama_perusahaan" value="{{ $employer->nama_perusahaan }}" required>
                        @error('nama_perusahaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat</label>
                        <input type="text" class="form-control @error('alamat_perusahaan') is-invalid @enderror"
                            name="alamat_perusahaan" value="{{ $employer->alamat }}" required>
                        @error('alamat_perusahaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kota</label>
                        <input type="text" class="form-control @error('kota') is-invalid @enderror" name="kota"
                            value="{{ $employer->kota }}" required>
                        @error('kota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Provinsi</label>
                        <input type="text" class="form-control @error('provinsi') is-invalid @enderror"
                            name="provinsi" value="{{ $employer->provinsi }}" required>
                        @error('provinsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kantor Pusat</label>
                        <input type="text" class="form-control @error('kantor_pusat') is-invalid @enderror"
                            name="kantor_pusat" value="{{ $employer->kantor_pusat }}" required>
                        @error('kantor_pusat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">website</label>
                        <input type="text" class="form-control @error('website') is-invalid @enderror" name="website"
                            value="{{ $employer->website }}" required>
                        @error('website')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Bidang Perusahaan</label>
                        <input type="text" class="form-control @error('bidang_perusahaan') is-invalid @enderror"
                            name="bidang_perusahaan" value="{{ $employer->bidang_perusahaan }}" required>
                        @error('bidang_perusahaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tahun Berdiri</label>
                        <input type="text" class="form-control" name="tahun_berdiri"
                            value="{{ $employer->tahun_berdiri }}" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" class="form-control @error('kode_pos') is-invalid @enderror"
                            name="kode_pos" value="{{ $employer->kode_pos }}" required>
                        @error('kode_pos')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Employer</label>
                        <input type="text" class="form-control @error('nama_employer') is-invalid @enderror"
                            name="nama_employer" value="{{ $employer->nama_lengkap }}" required>
                        @error('nama_employer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                            name="nomor_telepon" value="{{ $employer->nomor_telepon }}" required>
                        @error('nomor_telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat Email</label>
                        <input type="text" class="form-control" name="alamat_email"
                            value="{{ $employer->alamat_email }}" required>
                        <div class="form-text">
                            Mengubah Alamat Email, Diperlukan Verifikasi Ulang
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jabatan</label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                            name="jabatan" value="{{ $employer->jabatan }}" required>
                        @error('jabatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status</label>
                        <select name="status"
                            class="form-select status_employer @error('status') is-invalid @enderror"
                            id="status_select">
                            <option value="active"
                                {{ old('status', $employer->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended"
                                {{ old('status', $employer->status) == 'suspended' ? 'selected' : '' }}>Suspended
                            </option>
                        </select>
                        <div class="form-text">
                            Harap berhati-hati saat mengubah status employer. Perubahan ini akan mempengaruhi status
                            semua loker yang terkait.
                        </div>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2 d-none" id="suspend_note_field">
                        <label for="" class="form-label fw-semibold">Alasan</label>
                        <textarea name="suspend_note" class="form-control @error('suspend_note') is-invalid @enderror" id="suspend_note"
                            cols="30" rows="10">{{ $employer->suspend_note }}</textarea>
                        <div class="form-text">
                            Mohon Untuk Mengisi Alasan Perusahaan ini Di Blokir
                        </div>
                        @error('suspend_note')
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


@if (session('modal') === 'editEmployer')
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
        const editEmployer = document.getElementById('editEmployer');
        editEmployer.addEventListener('change', function() {
            const status = event.target;

            if (status.classList.contains('status_employer')) {
                const note = editEmployer.querySelector('#suspend_note');
                const field_note = editEmployer.querySelector('#suspend_note_field');
                if (status.value == 'suspended') {
                    field_note.classList.remove('d-none');
                    note.setAttribute('required', true);
                } else {
                    field_note.classList.add('d-none');
                    note.setAttribute('required', false);
                }
            }
        });
    </script>
@endpush
