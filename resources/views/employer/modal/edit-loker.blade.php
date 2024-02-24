<div class="modal fade" id="editLoker" tabindex="-1" aria-labelledby="editLokerModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Edit Loker Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">

                <form action="{{ Route('employer.loker.update', ['id' => $loker->id]) }}" class="form-validate"
                    method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="nama_pekerjaan" class="form-label fw-semibold">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan"
                            placeholder="Nama Pekerjaan" value="{{ $loker->nama_pekerjaan }}" required>
                    </div>
                    <div class="my-2">
                        <label for="jenis_pekerjaan" class="form-label fw-semibold">Jenis Pekerjaan</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-select" required>
                            <option value="Full Time" @if ($loker->jenis_pekerjaan === 'Full Time') selected @endif>Full Time
                            </option>
                            <option value="Part Time" @if ($loker->jenis_pekerjaan === 'Part Time') selected @endif>Part Time
                            </option>
                            <option value="Contract" @if ($loker->jenis_pekerjaan === 'Contract') selected @endif>Contract</option>
                            <option value="Volunteer"@if ($loker->jenis_pekerjaan === 'Volunteer') selected @endif>Volunteer
                            </option>
                            <option value="Internship"@if ($loker->jenis_pekerjaan === 'Internship') selected @endif>Internship
                            </option>
                            <option value="Other"@if ($loker->jenis_pekerjaan === 'Other') selected @endif>Other</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="tipe_pekerjaan" class="form-label fw-semibold">Tipe Pekerjaan</label>
                        <select name="tipe_pekerjaan" id="tipe_pekerjaan" class="form-select" required>
                            <option value="" selected disabled>Pilih Tipe Pekerjaan</option>
                            <option value="WFO" @if ($loker->tipe_pekerjaan === 'WFO') selected @endif>WFO</option>
                            <option value="WFH" @if ($loker->tipe_pekerjaan === 'WFH') selected @endif>WFH</option>
                            <option value="Hybrid" @if ($loker->tipe_pekerjaan === 'Hybrid') selected @endif>Hybrid</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <label for="lokasi_pekerjaan" class="form-label fw-semibold">Lokasi</label>
                        <input type="text" name="lokasi_pekerjaan" value="{{ $loker->lokasi_pekerjaan }}"
                            class="form-control" required>
                    </div>
                    <div class="my-2">
                        <label for="deadline" class="form-label fw-semibold">Deadline</label>
                        <input type="date" class="form-control" value="{{ $loker->deadline->format('Y-m-d') }}"
                            name="deadline" required>
                    </div>
                    <div class="my-2">
                        <input type="checkbox" name="status_pekerjaan" class="form-check-input"
                            @if ($loker->status === 'Open') checked @endif>
                        <label for="" class="form-check-label">Open For Recruitment</label>
                        <div class="form-text">
                            Centang Untuk Membagikan Lowongan Kerja
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="deskripsi_pekerjaan" class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                        <div class="form-text">
                            Minimal 50 Kata
                        </div>
                        <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" cols="30" rows="10" class="form-control"
                            required>{{ $loker->deskripsi_pekerjaan }}</textarea>
                    </div>
                    <div class="my-2">
                        <label for="poster" class="form-label fw-semibold">Poster Lowongan Kerja</label>
                        <input type="file" class="form-control" name="poster">
                        <div class="form-text">
                            PNG Format
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
