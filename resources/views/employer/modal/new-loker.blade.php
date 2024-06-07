<div class="modal fade" id="newLoker" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Tambah Lowongan Pekerjaan Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ Route('employer.loker.new') }}" class="form-validate" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="">
                        <label for="nama_pekerjaan" class="form-label fw-semibold">Nama Pekerjaan</label>
                        <input type="text" class="form-control @error('nama_pekerjaan') is-invalid @enderror"
                            id="nama_pekerjaan" name="nama_pekerjaan" placeholder="Nama Pekerjaan"
                            value="{{ old('nama_pekerjaan') }}" required>
                        @error('nama_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="jenis_pekerjaan" class="form-label fw-semibold">Jenis Pekerjaan</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-select"
                            value="{{ old('jenis_pekerjaan') }}" required>
                            <option value="" selected disabled>Pilih Jenis Pekerjaan</option>
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Contract">Contract</option>
                            <option value="Volunteer">Volunteer</option>
                            <option value="Internship">Internship</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="tipe_pekerjaan" class="form-label fw-semibold">Tipe Pekerjaan</label>
                        <select name="tipe_pekerjaan" id="tipe_pekerjaan" class="form-select"
                            value="{{ old('tipe_pekerjaan') }}" required>
                            <option value="" selected disabled>Pilih Tipe Pekerjaan</option>
                            <option value="WFO">WFO</option>
                            <option value="WFH">WFH</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="lokasi_pekerjaan" class="form-label fw-semibold">Lokasi</label>
                        <input type="text" name="lokasi_pekerjaan"
                            class="form-control @error('lokasi_pekerjaan') is-invalid @enderror"
                            value="{{ old('lokasi_pekerjaan') }}" required>
                        @error('lokasi_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="deadline" class="form-label fw-semibold">Deadline</label>
                        <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                            id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                        @error('deadline')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="deskripsi_pekerjaan" class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                        <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" cols="30" rows="10"
                            class="form-control @error('deskripsi_pekerjaan') is-invalid @enderror" required>{{ old('deskripsi_pekerjaan') }}</textarea>
                        @error('deskripsi_pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="poster" class="form-label fw-semibold">Poster Lowongan Kerja</label>
                        <input type="file" class="form-control @error('poster') is-invalid @enderror" name="poster">
                        <div class="form-text">
                            PNG Format
                        </div>
                        @error('poster')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('modal') === 'newLoker')
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
