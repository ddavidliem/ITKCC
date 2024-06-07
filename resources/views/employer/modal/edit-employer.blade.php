<div class="modal fade" id="editEmployer" tabindex="-1" aria-labelledby="editEmployer" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold">Mengubah Data Employer</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-labelledby="close"> </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ Route('employer.profile.update') }}" method="post" class="form-validate" novalidate>
                    @csrf
                    @method('put')
                    <div class="">
                        <label for="" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            name="nama_lengkap" value="{{ $employer->nama_lengkap }}">
                        @error('nama_lengkap')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Jabatan</label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan"
                            value="{{ $employer->jabatan }}">
                        @error('jabatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                            name="nomor_telepon" value="{{ $employer->nomor_telepon }}">
                        @error('nomor_telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="" class="form-label fw-semibold">Email</label>
                        <input type="text" class="form-control @error('alamat_email') is-invalid @enderror"
                            name="alamat_email" value="{{ $employer->alamat_email }}">
                        <div class="form-text">
                            Jika Anda merencanakan untuk mengganti alamat email, pastikan untuk melakukan verifikasi
                            email ulang.
                        </div>
                        @error('alamat_email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="my-4 d-flex justify-content-end">
                        <button class="btn btn-outline-dark">update</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

@if (session('modal') === 'editEmployer')
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
