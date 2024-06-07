<div class="modal  fade" id="addTopic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Tambah Topik Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form action="{{ Route('admin.appointment.topik.new') }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Topik Konseling</label>
                        <input type="text" class="form-control @error('topik') is-invalid @enderror"
                            name="topik_konseling" @error('topik') value="{{ old('topik') }}" @enderror required>
                        @error('topik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status Topik Konseling</label>
                        <select name="status_topik_konseling" id="" class="form-select" required>
                            <option value="" disabled selected>Pilih Status Topik Konseling</option>
                            <option value="enable">Aktif</option>
                            <option value="disable">Tidak Aktif</option>
                        </select>
                        <div class="form-text">
                            Pilih Status Topik Konseling
                        </div>
                    </div>
                    <div class="my-4">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-dark">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('modal') === 'addTopic')
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
