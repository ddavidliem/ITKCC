@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="d-flex p-4">
            <div class="col-4 min-vh-50  bg-white rounded p-4">
                <div>
                    <input type="text" class="form-control" placeholder="Search Berita" id="search">
                </div>
                <div class="my-3">
                    <button class="btn btn-outline-dark new-Btn" data-bs-target="#newContent" data-bs-toggle="modal">Tambah
                        Konten</button>
                </div>
                <div class="my-2 max-vh-75 overflow-auto">
                    <table class="table table-hover table-borderless" role="tablist" id="tablist">
                        <thead class="table-light">
                            <tr class="position-sticky top-0">
                                <th class="fw-semibold">Daftar Konten</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($content as $item)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0)" type="button" role="tab"
                                            class="text-decoration-none text-dark d-flex p-2"
                                            data-bs-target="#tab-{{ $item->id }}" data-bs-toggle="tab">
                                            <div class="col-10">
                                                <h6 class="fw-semibold my-2 text-capitalize">
                                                    {{ $item->title }}</h6>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-8 mx-2 min-vh-75 bg-white rounded p-4">
                <div class="mb-4 p-4">
                    <h4 class="fw-semibold">Daftar Halaman Konten</h4>
                </div>
                <div class="tab-content" id="tab-content">
                    @foreach ($content as $item)
                        <div id="tab-{{ $item->id }}" class="p-2 tab-pane" role="tabpanel">
                            <div class="bg-white p-44 min-vh-10 mb-3">
                                <div class="d-flex mb-4">
                                    <h3 class="fw-bold col-10">Detail Konten</h3>
                                    <div class="col-2 d-flex justify-content-end">
                                        <button class="btn btn-outline-dark mx-2 edit-content-button" data-bs-toggle="modal"
                                            data-bs-target="#editContent"
                                            data-id="{{ Route('admin.contents.detail', ['id' => $item->id]) }}"
                                            data-url="{{ Route('admin.contents.update', ['id' => $item->id]) }}">Edit</button>
                                        <button class="btn btn-outline-danger delete-content-button" data-bs-toggle="modal"
                                            data-bs-target="#deleteContent" data-content="{{ $item->title }}"
                                            data-url="{{ Route('admin.contents.delete', ['id' => $item->id]) }}">Delete</button>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <div class="my-4 col-8 offset-2">
                                        @if ($item->image != null)
                                            <img src="{{ asset('content/' . $item->image) }}" class="img-fluid"
                                                alt="">
                                        @endif
                                    </div>
                                    <div class="my-4">
                                        <div class="my-2">
                                            <label for="" class="form-label">Kategori</label>
                                            <h6 class="fw-semibold">{{ $item->category }}</h6>
                                        </div>
                                        <div class="my-2">
                                            <label for="" class="form-label">Status</label>
                                            <h6 class="fw-semibold">{{ $item->status }}</h6>
                                        </div>
                                        <div class="my-2">
                                            <label for="" class="form-label">Title</label>
                                            <h6 class="fw-semibold">{{ $item->title }}</h6>
                                        </div>
                                        <div class="my-2">
                                            <label for="" class="form-label">Body</label>
                                            <h6 class="fw-semibold">{{ $item->body }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('admin.content.modal.delete-content')
    @include('admin.content.modal.edit-content')
    @include('admin.content.modal.new-content')
@endsection
@push('script')
    <script type="module">
        $(document).ready(function() {
            $('#search').on('input', function() {
                searchTable();
            });

            function searchTable() {
                const searchQuery = $('#search').val().toLowerCase();
                const $rows = $('tbody tr');
                $rows.show();
                $rows.each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.indexOf(searchQuery) === -1) {
                        $(this).hide();
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const category = document.getElementById('content_category');
            const input = document.getElementById('body-input');

            category.addEventListener('change', function() {
                if (category.value === 'Carousel') {
                    input.disabled = true;
                    input.removeAttribute('required');
                }
                if (category.value === 'Berita') {
                    input.disabled = false;
                    input.addAttribute('required');
                }
            })

            const deleteBtn = document.querySelectorAll('.delete-content-button');
            const deleteForm = document.getElementById('deleteForm');
            const deleteTarget = document.getElementById('deleteTarget');
            Array.from(deleteBtn).forEach(btn => {
                btn.addEventListener('click', function() {
                    deleteForm.setAttribute('action', btn.getAttribute('data-url'));
                    deleteTarget.innerHTML = btn.getAttribute('data-content');
                });
            });

            const editBtn = document.querySelectorAll('.edit-content-button');
            const editForm = document.getElementById('editForm');
            Array.from(editBtn).forEach(btn => {
                btn.addEventListener('click', function() {

                    $.ajax({
                        type: "GET",
                        url: this.getAttribute('data-id'),
                        success: function(response) {
                            editForm.querySelector('#edit_category').value = response
                                .category;
                            editForm.querySelector('#editTitle').value = response.title;
                            editForm.querySelector('#editBody').value = response.body;

                            if (response.category === 'Carousel') {
                                editForm.querySelector('#editBody').disabled = true;
                            }
                        }
                    });
                    editForm.setAttribute('action', btn.getAttribute('data-url'));
                });

            });

        });
    </script>
@endpush
