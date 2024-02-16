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
                        <input type="text" class="form-control" value="{{ $user->nama_lengkap }}"
                            name="nama_lengkap">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Alamat Email</label>
                        <input type="text" class="form-control" value="{{ $user->alamat_email }}"
                            name="alamat_email">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control" value="{{ $user->nomor_telepon }}"
                            name="nomor_telepon">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Disabilitas</label>
                        <input type="text" class="form-control" value="{{ $user->disabilitas }}" name="disabilitas">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text" class="form-control" value="{{ $user->tempat_lahir }}"
                            name="tempat_lahir">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date" class="form-control" value="{{ $user->tanggal_lahir }}"
                            name="tanggal_lahir">
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
                        <input type="text" class="form-control" value="{{ $user->alamat }}" name="alamat"
                            id="alamat" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kota</label>
                        <input type="text" class="form-control" value="{{ $user->kota }}" name="kota"
                            id="kota" required>
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kode Pos</label>
                        <input type="text" class="form-control" value="{{ $user->kode_pos }}" name="kode_pos"
                            id="kode_pos" required>
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
                        <input type="text" class="form-control" value="{{ $user->nim }}" name="nim"
                            id="nim">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">IPK</label>
                        <input type="text" class="form-control" value="{{ $user->ipk }}" name="ipk"
                            id="ipk">
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Pendidikan Tertinggi</label>
                        <select name="pendidikan_tertinggi" class="form-select" id="pendidikan_tertinggi">
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
                                    {{ $user->status_perkawinan == $value ? 'seleceted' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button class="btn btn-outline-dark" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
