@extends('layouts.app')

@section('content')
    <div class="container p-4 ">
        <div class="bg-white min-vh-100 max-vh-100 overflow-auto p-4">
            <div class="my-4 d-flex justify-content-between">
                <h4 class="fw-bold">Berita Pusat Karir ITK</h4>
                <div class="col-4">
                    <input type="search" role="search" class="form-control" id="search" placeholder="Search">
                </div>
            </div>
            <table class="table table-hover table-borderless">
                <tbody>
                    @foreach ($content as $item)
                        <tr>
                            <td class="p-4">
                                <a href="/berita/{{ $item->id }}" class="d-flex text-decoration-none text-dark">
                                    <div class="col-8">
                                        <h5 class="fw-semibold">{{ $item->title }}</h5>
                                        <p class="my-2">{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
    </script>
@endpush
