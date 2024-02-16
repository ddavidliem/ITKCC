@extends('layouts.user')


@section('content')
    <div class="p-4">
        <div class="bg-white min-vh-100 rounded p-4">
            <div class="d-flex justify-content-between">
                <h4 class="fw-semibold">Daftar Lowongan Kerja</h4>
                <div class="col-4">
                    <input type="text" id="search" role="search" class="form-control" placeholder="Search Lowongan Kerja">
                </div>
            </div>
            <div class="my-4 min-vh-75 max-vh-100 overflow-auto">
                <table class="table table-hover table-borderless">
                    <thead class="table-light">
                        <tr class="position-sticky top-0">
                            <td class="fw-semibold p-2">Lowongan Kerja</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loker as $item)
                            <tr>
                                <td class="p-4">
                                    <a href="/loker/{{ $item->id }}" class="d-flex text-decoration-none text-dark">
                                        <div class="col-1">
                                            <img src="{{ asset('logo/' . $item->employer->logo_perusahaan) }}"
                                                alt="" class="img-fluid px-1 align-self-center">
                                        </div>
                                        <div class="col-9 px-4">
                                            <h5 class="fw-semibold">{{ $item->nama_pekerjaan }}</h5>
                                            <ul class="list-unstyled">
                                                <li class="text-capitalize fw-semibold">
                                                    {{ $item->employer->nama_perusahaan }}
                                                </li>
                                                <li class="text-capitalize">{{ $item->lokasi_pekerjaan }} |
                                                    {{ $item->jenis_pekerjaan }} | {{ $item->tipe_pekerjaan }}</li>
                                                @if ($item->status === 'Open')
                                                    <li class="text-capitalize text-success">Open For Recruitment</li>
                                                @elseif($item->status === 'Closed')
                                                    <li class="text-capitalize text-danger">Closed For Recruitment</li>
                                                @endif
                                                </li>
                                                <li>
                                                    Jumlah Pelamar: {{ $item->applicants()->count() }}
                                                </li>
                                            </ul>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
