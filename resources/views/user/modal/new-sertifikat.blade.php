<div class="modal fade" id="newSertifikat" tabindex="-1" aria-labelledby="sertifikatModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Form Penambahan Sertifikat</h1>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <form action="{{ Route('user.sertifikat.new') }}" method="post" class="form-validate" novalidate>
                @csrf
                <div class="modal-body min-vh-75 scroll-modal p-4">
                    <div class="mb-3">
                        <label for="" class="form-label fw-semibold">Title Sertifikat</label>
                        <input type="text" class="form-control @error('title_sertifikat') is-invalid @enderror"
                            name="title_sertifikat" placeholder="Title Sertifikat" required autofocus>
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3">
                        <label for="organisasi" class="form-label fw-semibold">Nama Organisasi</label>
                        <input type="text" class="form-control @error('organisasi_sertifikat') is-invalid @enderror"
                            required placeholder="Nama Organisasi" name="organisasi_sertifikat">
                        @error('organisasi_sertifikat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 p-2 row d-flex justify-content-evenly">
                        <label for="" class="form-label fw-semibold">Tanggal Terbit Sertifikat</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan_terbit" class="form-label fw-semibold">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_terbit_sertifikat" id=""
                                    class="form-select @error('bulan_terbit_sertifikat') is-invalid @enderror" required>
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
                            @error('bulan_terbit_sertifikat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 my-2">
                            <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit</label>
                            <div class="col-10">
                                <select name="tahun_terbit_sertifikat"
                                    class="form-select year @error('tahun_terbit_sertifikat') is-invalid @enderror"
                                    required>
                                    <option value="" selected disabled>Tahun Terbit</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('tahun_terbit_sertifikat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="my-3 p-2 row d-flex justify-content-evenly">
                        <label for="" class="form-label fw-semibold">Tanggal Berakhir Sertifikat</label>
                        <div class="col-lg-6 my-2">
                            <label for="bulan_berakhir" class="form-label fw-semibold ">Bulan</label>
                            <div class="col-10">
                                <select name="bulan_berakhir_sertifikat"
                                    class="form-select @error('bulan_berakhir_sertifikat') is-invalid @enderror">
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
                            @error('bulan_berakhir_sertifikat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-lg-6 my-2">
                            <label for="tahun_berakhir" class="form-label fw-semibold">Tahun Berakhir</label>
                            <div class="col-10">
                                <select name="tahun_berakhir_sertifikat"
                                    class="form-select year @error('tahun_berakhir_sertifikat') is-invalid @enderror">
                                    <option value="" selected disabled>Tahun Berakhir</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('tahun_berakhir_sertifikat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="my-3">
                        <label for="id_sertifikat" class="form-label fw-semibold">ID Sertifikat</label>
                        <input type="text" name="id_sertifikat"
                            class="form-control @error('id_sertifikat') is-invalid @enderror">
                        <div class="form-text">
                            ID Sertifikat Dapat Dikosongkan
                        </div>
                        @error('id_sertifikat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="url_sertifikat" class="form-label fw-semibold">URL Sertifikat</label>
                        <input type="text" name="url_sertifikat"
                            class="form-control @error('url_sertifikat') is-invalid @enderror">
                        <div class="form-text">
                            URL Sertifikat Dapat Dikosongkan
                        </div>
                        @error('url_sertifikat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@if (session('modal') === 'newSertifikat')
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
