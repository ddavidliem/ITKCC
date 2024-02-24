<div class="modal fade form-pengalaman" id="editPengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Mengubah Data Pengalaman</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <form method="post" class="form-validate" id="editPengalamanForm" novalidate>
                @csrf
                @method('put')
                <div class="modal-body min-vh-50 scroll-modal p-4">
                    <div class="">
                        <label for="title" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" id="title_pengalaman" name="title"
                            placeholder="Title Pekerjaan" required autofocus>
                    </div>
                    <div class="my-3">
                        <label for="jenis_pekerjaan" class="form-label fw-semibold">Jenis
                            Pekerjaan</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-select" required>
                            <option value="" selected disabled>Pilih Jenis Pekerjaan</option>
                            <option value="Full Time">Full TIme</option>
                            <option value="Part Time">Part TIme</option>
                            <option value="Freelance">Freelance</option>
                            <option value="Contract">Contract</option>
                            <option value="Internship">Internship</option>
                            <option value="Apprenticeship">Apprenticeship</option>
                        </select>
                    </div>

                    <div class="my-3">
                        <label for="organisasi" class="form-label fw-semibold">Organisasi</label>
                        <input type="text" class="form-control" id="organisasi_pengalaman" name="organisasi"
                            placeholder="organisasi" required>
                    </div>

                    <div class="my-3">
                        <label for="lokasi_pekerjaan" class="form-label fw-semibold">Lokasi Pekerjaan</label>
                        <input type="text" class="form-control" id="lokasi_pengalaman" name="lokasi_pekerjaan"
                            placeholder="Balikpapan Selatan, Kalimantan Timur, Indonesia" required>
                    </div>

                    <div class="my-2 p-2 row d-flex justify-content-evenly">
                        <label for="" class="fw-semibold">Tanggal Mulai Bekerja</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan_mulai" class="form-label fw-semibold">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_mulai" id="bulan_mulai" class="form-select" required>
                                    <option value="" selected disabled>Bulan Mulai</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 my-2">
                            <label for="tahun_mulai" class="form-label fw-semibold">Tahun Mulai</label>
                            <div class="col-10">
                                <select name="tahun_mulai" id="tahun_mulai" class="form-select" required>
                                    <option value="" selected disabled>Tahun Mulai</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-check-input modal-checkbox" name="present_box"
                                value="Present">
                            <label for="" class="form-check-label">Present ( Saat Ini Masih
                                Bekerja)</label>
                        </div>
                    </div>

                    <div class="my-2 p-2 row d-flex justify-content-evenly">
                        <label for="" class="fw-semibold">Tanggal Selesai Bekerja</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan" class="form-label fw-semibold">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_selesai" id="bulan_selesai" class="form-select end-date">
                                    <option value="" selected disabled>Bulan Selesai</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 my-2">
                            <label for="tahun_selesai" class="form-label fw-semibold">Tahun</label>
                            <div class="col-10">
                                <select name="tahun_selesai" id="tahun_selesai" class="form-select end-date">
                                    <option value="" selected disabled>Tahun Selesai</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="my-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                        <textarea name="deskripsi_pengalaman" id="deskripsi_pengalaman" cols="30" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="my-1 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
