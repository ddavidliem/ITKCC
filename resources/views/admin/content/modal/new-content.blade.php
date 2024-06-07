<div class="modal fade" id="newContent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Menambah Konten Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <h5 class="fw-bold">Form Menambah Konten Baru</h5>
                <form method="POST" action="{{ Route('admin.contents.create') }}" id="newContentForm"
                    class="form-validate" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Kategori</label>
                        <select name="category" id="content_category"
                            class="form-select @error('category') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Kategori
                            </option>
                            <option value="Carousel">Carousel
                            </option>
                            <option value="Berita">Berita</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Image</label>
                        <input type="file" class="form-control @error('img_content') is-invalid @enderror"
                            name="img_content" required>
                        <div class="form-text">
                            Maksimal file 2MB, Format PNG/JPEG.
                        </div>
                        @error('img_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Title</label>
                        <input type="text" class="form-control @error('title_content') is-invalid @enderror"
                            name="title_content" value="{{ old('title_content') }}" required>
                        @error('title_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Body</label>
                        <textarea name="body_content" id="body-input" class="form-control @error('body_content') is-invalid @enderror">{{ old('body_content') }}</textarea>
                        @error('body_content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-dark">Tambah Konten</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@if (session('modal') === 'newContent')
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
