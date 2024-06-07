<div class="modal fade form-pengalaman" id="editPengalaman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Mengubah Data Pengalaman</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <form method="post" class="form-validate form-edit-pengalaman" id="editPengalamanForm" novalidate>
                @csrf
                @method('put')
                <div class="modal-body min-vh-50 scroll-modal p-4">
                    <div class="">
                        <label for="title" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control @error('title_pengalaman') is-invalid @enderror"
                            id="title_pengalaman" name="title_pengalaman" placeholder="Title Pekerjaan" required
                            autofocus>
                        @error('title_pengalaman')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="organisasi" class="form-label fw-semibold">Organisasi</label>
                        <input type="text" class="form-control @error('organisasi_pengalaman') is-invalid @enderror"
                            id="organisasi_pengalaman" name="organisasi_pengalaman" placeholder="organisasi" required>
                        @error('organisasi_pengalaman')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="lokasi_pekerjaan" class="form-label fw-semibold">Lokasi Pekerjaan</label>
                        <input type="text" class="form-control @error('lokasi_pekerjaan') is-invalid @enderror"
                            id="lokasi_pengalaman" name="lokasi_pekerjaan_pengalaman"
                            placeholder="Balikpapan Selatan, Kalimantan Timur, Indonesia" required>
                        @error('lokasi_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-2 p-2 row d-flex justify-content-evenly">
                        <label for="" class="fw-semibold">Tanggal Mulai Bekerja</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan_mulai" class="form-label fw-semibold">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_mulai_pengalaman" id="bulan_mulai"
                                    class="form-select @error('bulan_mulai_pengalaman') is-invalid @enderror" required>
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
                            @error('bulan_mulai_pengalaman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 my-2">
                            <label for="tahun_mulai" class="form-label fw-semibold">Tahun Mulai</label>
                            <div class="col-10">
                                <select name="tahun_mulai_pengalaman" id="tahun_mulai"
                                    class="form-select @error('tahun_mulai_pengalaman') is-invalid @enderror" required>
                                    <option value="" selected disabled>Tahun Mulai</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('tahun_mulai_pengalaman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-check-input modal-checkbox" name="present_box"
                                value="Present" id="present_box">
                            <label for="" class="form-check-label">Present ( Saat Ini Masih
                                Bekerja)</label>
                        </div>
                    </div>

                    <div class="my-2 p-2 row d-flex justify-content-evenly">
                        <label for="" class="fw-semibold">Tanggal Selesai Bekerja</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan" class="form-label fw-semibold">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_selesai_pengalaman" id="bulan_selesai"
                                    class="form-select end-date @error('bulan_selesai_pengalaman') is-invalid @enderror">
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
                            @error('bulan_selesai_pengalaman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 my-2">
                            <label for="tahun_selesai" class="form-label fw-semibold">Tahun</label>
                            <div class="col-10">
                                <select name="tahun_selesai_pengalaman" id="tahun_selesai"
                                    class="form-select end-date @error('tahun_selesai_pengalaman') is-invalid @enderror">
                                    <option value="" selected disabled>Tahun Selesai</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('tahun_selesai_pengalaman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="my-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                        <textarea name="deskripsi_pengalaman" id="deskripsi_pengalaman" cols="30" rows="5"
                            class="form-control @error('deskripsi_pengalaman') is-invalid @enderror"></textarea>
                        @error('deskripsi_pengalaman')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-1 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

@if (session('modal') === 'editPengalaman')
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
