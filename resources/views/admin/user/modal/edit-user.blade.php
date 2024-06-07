<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Mengubah Data User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ Route('admin.user.update', ['id' => $user->id]) }}"
                    class="form-validate" id="editUserForm" novalidate>
                    @csrf
                    @method('Put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            value="{{ $user->nama_lengkap }}" name="nama_lengkap">
                        @error('nama_lengkap')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat Email</label>
                        <input type="text" class="form-control @error('alamat_email') is-invalid @enderror"
                            value="{{ $user->alamat_email }}" name="alamat_email">
                        @error('alamat_email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                            value="{{ $user->nomor_telepon }}" name="nomor_telepon">
                        @error('nomor_telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Disabilitas</label>
                        <input type="text" class="form-control @error('disabilitas') is-invalid @enderror"
                            value="{{ $user->disabilitas }}" name="disabilitas">
                        @error('disabilitas')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                            value="{{ $user->tempat_lahir }}" name="tempat_lahir">
                        @error('tempat_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ $user->tanggal_lahir }}" name="tanggal_lahir">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                            @foreach (['pria' => 'Pria', 'wanita' => 'Wanita'] as $value => $label)
                                <option
                                    value="{{ $value }}"{{ $user->jenis_kelamin == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Agama</label>
                        <select name="agama" id="agama" class="form-select" required>
                            @foreach (['Islam' => 'Islam', 'Kristen Protestan' => 'Kristen', 'Kristen Katolik' => 'katolik', 'Hindu' => 'Hindu', 'Budha' => 'Budha', 'Konghucu' => 'Konghucu'] as $value => $label)
                                <option value="{{ $value }}" {{ $user->agama == $value ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kewarganegaraan</label>
                        <select name="kewarganegaraan" class="form-select" required>
                            @foreach (['WNI' => 'WNI', 'WNA' => 'WNA'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $user->kewarganegaraan == $value ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat</label>
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                            value="{{ $user->alamat }}" name="alamat" id="alamat" required>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kota</label>
                        <input type="text" class="form-control @error('kota') is-invalid @enderror"
                            value="{{ $user->kota }}" name="kota" id="kota" required>
                        @error('kota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" class="form-control @error('kode_pos') is-invalid @enderror"
                            value="{{ $user->kode_pos }}" name="kode_pos" id="kode_pos" required>
                        @error('kode_pos')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Program Studi</label>
                        <select name="program_studi" id="program_studi" class="form-select" required>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->program_studi }}"
                                    {{ $user->program_studi == $item->program_studi ? 'selected' : '' }}>
                                    {{ $item->program_studi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nim</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror"
                            value="{{ $user->nim }}" name="nim" id="nim">
                        @error('nim')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">IPK</label>
                        <input type="text" class="form-control @error('ipk') is-invalid @enderror"
                            value="{{ $user->ipk }}" name="ipk" id="ipk">
                        @error('ipk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Pendidikan Tertinggi</label>
                        <select name="pendidikan_tertinggi"
                            class="form-select @error('pendidikan_tertinggi') is-invalid @enderror"
                            id="pendidikan_tertinggi">
                            @foreach (['Sekolah Dasar' => 'SD', 'Sekolah Menengah Pertama' => 'SMP', 'Sekolah Menengah Atas' => 'SMA', 'Diploma 1' => 'D-1', 'Diploma 2' => 'D-2', 'Diploma 3 ' => 'D-3', 'Strata 1' => 'S-1', 'Strata 2' => 'S-2', 'Strata 3' => 'S-3'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $user->pendidikan_tertinggi == $value ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status Perkawinan</label>
                        <select name="status_perkawinan" class="form-select" id="status_perkawinan">
                            @foreach (['Belum Kawin' => 'Belum Kawin', 'Kawin' => 'Kawin', 'Cerai Hidup' => 'Cerai Hidup', 'Cerai Mati' => 'Cerai Mati'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $user->status_perkawinan == $value ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status</label>
                        <select name="user_status"
                            class="form-select status-select @error('status') is-invalid @enderror"
                            id="user_status_select">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="suspended"
                                {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        <div class="form-text">
                            Harap berhati-hati saat mengubah status user.
                        </div>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2 d-none" id="user_suspend_field">
                        <label for="" class="form-label fw-semibold">Alasan</label>
                        <textarea name="user_suspend_note" class="form-control @error('user_suspend_note') is-invalid @enderror"
                            id="user_suspend_note" cols="30" rows="10">{{ $user->suspend_note }}</textarea>
                        <div class="form-text">
                            Mohon Mengisi Alasan User ini Di Blokir
                        </div>
                        @error('user_suspend_note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-dark" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@if (session('modal') === 'editUser')
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
        const editUser = document.getElementById('editUser');
        editUser.addEventListener('change', function() {
            const status = event.target;

            if (status.classList.contains('status-select')) {
                const field_note = editUser.querySelector('#user_suspend_field');
                const field_text_area = editUser.querySelector('#user_suspend_note');

                if (status.value == 'suspended') {
                    field_note.classList.remove('d-none');
                    filed_text_area.setAttribute('required', true);
                } else {
                    field_note.classList.add('d-none');
                    field_text_area.setAttribute('required', false);
                }
            }
        });
    </script>
@endpush
