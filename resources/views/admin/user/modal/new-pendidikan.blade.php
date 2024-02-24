<div class="modal fade" id="newPendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Menambah Data Pendidikan</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <form method="post" action="{{ Route('user.pendidikan.new') }}" class="form-validate"
                id="newPendidikanForm" novalidate>
                @csrf
                <div class="modal-body min-vh-75 scroll-modal p-4">
                    <div class="mb-3">
                        <label for="" class="form-label fw-semibold">Nama Sekolah</label>
                        <input type="text" class="form-control" name="nama_sekolah" placeholder="Nama Sekolah"
                            required autofocus>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Bidang Studi</label>
                        <input type="text" class="form-control" required placeholder="Bidang Studi"
                            name="bidang_studi">
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Tahun Lulus</label>
                        <div class="">
                            <select name="tahun_lulus" class="form-select year" required>
                                <option value="" selected disabled>Tahun Terbit</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Tingkat Pendidikan</label>
                        <select name="tingkat_pendidikan" class="form-select">
                            @foreach (['Sekolah Menengah Atas' => 'SMA', 'Diploma 1' => 'D-1', 'Diploma 2' => 'D-2', 'Diploma 3 ' => 'D-3', 'Strata 1' => 'S-1', 'Strata 2' => 'S-2', 'Strata 3' => 'S-3'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $user->pendidikan_tertinggi == $value ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Alamat Sekolah</label>
                        <textarea class="form-control" name="alamat_sekolah" cols="30" rows="5"></textarea>
                    </div>
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Keterangan</label>
                        <textarea class="form-control" name="keterangan" cols="30" rows="10"></textarea>
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
