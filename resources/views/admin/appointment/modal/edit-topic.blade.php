<div class="modal  fade" id="editTopic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold">Mengubah Topik Konseling</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"></button>
            </div>
            <div class="p-4">
                <form method="POST" class="needs-validation" id="editTopicForm" novalidate>
                    @csrf
                    @method('put')
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Topik Konseling</label>
                        <input type="text" class="form-control @error('edit_topik') is-ivalid @enderror"
                            id="edit-topik" name="edit_topik" required>
                        @error('edit_topik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Status Topik Konseling</label>
                        <select name="edit_status_topik"
                            class="form-select @error('edit_status_topik') is-invalid @enderror" id="edit-status-topik"
                            required>
                            <option value="" disabled selected>Pilih Status Topik</option>
                            <option value="enable">Aktif</option>
                            <option value="disable">Tidak Aktif</option>
                        </select>
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

@if (session('modal') === 'editTopic')
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
