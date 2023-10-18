<div class="modal fade" id="sertifikatModal" tabindex="-1" aria-labelledby="sertifikatModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">User Certificate Form</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <form action="/submit-sertifikat" method="post" class="form-validate" novalidate>
                @csrf
                <div class="modal-body min-vh-75 scroll-modal p-4">
                    <div class="my-3">
                        <label for="" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control" id="title" name="title_sertifikat"
                            placeholder="Title Sertifikat" required autofocus>
                    </div>
                    <div class="my-3">
                        <label for="organisasi" class="form-label fw-semibold">Nama Organisasi</label>
                        <input type="text" class="form-control" required placeholder="Nama Organisasi"
                            name="organisasi">
                    </div>
                    <div class="my-3 p-2 row d-flex justify-content-evenly">
                        <label for="" class="form-label fw-semibold">Tanggal Terbit Sertifikat</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan_terbit" class="form-label fw-semibold">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_terbit" id="" class="form-select" required>
                                    <option value="" selected disabled>Bulan Terbit</option>
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
                            <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit</label>
                            <div class="col-10">
                                <select name="tahun_terbit" class="form-select year" required>
                                    <option value="" selected disabled>Tahun Terbit</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="my-3 p-2 row d-flex justify-content-evenly">
                        <label for="" class="form-label fw-semibold">Tanggal Berakhir Sertifikat</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan_berakhir" class="form-label fw-semibold">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_berakhir" class="form-select">
                                    <option value="" selected disabled>Bulan Terakhir</option>
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
                            <label for="tahun_berakhir" class="form-label fw-semibold">Tahun Berakhir</label>
                            <div class="col-10">
                                <select name="tahun_berakhir" class="form-select year">
                                    <option value="" selected disabled>Tahun Berakhir</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="my-3">
                        <label for="id_sertifikat" class="form-label fw-semibold">ID Sertifikat</label>
                        <input type="text" name="id_sertifikat" class="form-control">
                        <div class="form-text">
                            ID Sertifikat Dapat Dikosongkan
                        </div>
                    </div>

                    <div class="my-3">
                        <label for="url_sertifikat" class="form-label fw-semibold">URL Sertifikat</label>
                        <input type="text" name="url_sertifikat" class="form-control">
                        <div class="form-text">
                            URL Sertifikat Dapat Dikosongkan
                        </div>
                    </div>

                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
