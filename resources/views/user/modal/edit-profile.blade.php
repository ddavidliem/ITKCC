<div class="modal fade" id="editProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Edit User Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="modal-body p-4 max-vh-75 overflow-auto">
                <form action="{{ Route('user.profile.update') }}" method="POST" class="form-validate" novalidate>
                    @csrf
                    @method('put')
                    <div class="">
                        <label for="" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            name="nama_lengkap" value="{{ $user->nama_lengkap }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" class="form-control @error('alamat_email') is-invalid @enderror"
                            name="alamat_email" value="{{ $user->alamat_email }}" required>
                        @error('alamat-email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                            name="nomor_telepon" value="{{ $user->nomor_telepon }}" required>
                        @error('nomor_telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nim</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim"
                            value="{{ $user->nim }}">
                        @error('nim')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">IPK</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" name="ipk"
                            value="{{ $user->ipk }}">
                        @error('nim')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Program Studi</label>
                        <select name="program_studi" id="program_studi"
                            class="form-select @error('program_studi') is-invalid @enderror" required>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->program_studi }}"
                                    {{ $user->program_studi == $item->program_studi ? 'selected' : '' }}>
                                    {{ $item->program_studi }}</option>
                            @endforeach
                        </select>
                        @error('program_studi')
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
                        @error('pendidikan_tertinggi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                            name="tempat_lahir" value="{{ $user->tempat_lahir }}" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kewarganegaraan</label>
                        <select name="kewarganegaraan"
                            class="form-select @error('kewarganegaraan') is-invalid @enderror" required>
                            @foreach (['WNI' => 'WNI', 'WNA' => 'WNA'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $user->kewarganegaraan == $value ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kewarganegaraan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id=""
                            class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                            @foreach (['pria' => 'Pria', 'wanita' => 'Wanita'] as $value => $label)
                                <option
                                    value="{{ $value }}"{{ $user->jenis_kelamin == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status Perkawinan</label>
                        <select name="status_perkawinan"
                            class="form-select @error('status_perkawinan') is-invalid @enderror"
                            id="status_perkawinan">
                            @foreach (['Belum Kawin' => 'Belum Kawin', 'Kawin' => 'Kawin', 'Cerai Hidup' => 'Cerai Hidup', 'Cerai Mati' => 'Cerai Mati'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $user->status_perkawinan == $value ? 'seleceted' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_perkawinan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Agama</label>
                        <select name="agama" id=""
                            class="form-select @error('agama') is-invalid @enderror" required>
                            @foreach (['Islam' => 'Islam', 'Kristen Protestan' => 'Kristen', 'Kristen Katolik' => 'katolik', 'Hindu' => 'Hindu', 'Budha' => 'Budha', 'Konghucu' => 'Konghucu'] as $value => $label)
                                <option value="{{ $value }}" {{ $user->agama == $value ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kota</label>
                        <input type="text" class="form-control @error('kota') is-invalid @enderror"
                            name="kota" value="{{ $user->kota }}">
                        @error('kota')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control @error('kode_pos') is-invalid @enderror"
                            name="kode_pos" value="{{ $user->kode_pos }}" required>
                        @error('kode_pos')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat</label>
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                            name="alamat" value="{{ $user->alamat }}" required>
                        @error('agama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-dark" type="submit">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('modal') === 'editProfile')
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
