@extends('layouts.admin')

@section('content')
    <div class="container p-4">
        <div class="p-4 d-flex">
            <div class="col-8 p-4 bg-white min-vh-100">
                <h4 class="fw-bold">Daftar Konten</h4>
                @if ($content->isEmpty())
                    @include('component.empty', ['message' => 'Konten Belum Ditambahkan'])
                @else
                    <div class="my-4 list-group list-group-flush max-vh-100 overflow-auto">
                        @foreach ($content as $item)
                            <div class="list-group-item p-2">
                                <a href="/contents/{{ $item->id }}" class="text-decoration-none text-dark ">
                                    <h6 class="fw-bold">{{ $item->title }}</h6>
                                    <ul class=" list-unstyled">
                                        <li>Upload : {{ $item->created_at }}</li>
                                        @if ($item->status == 1)
                                            <li>Status : Aktif</li>
                                        @else
                                            <li>Status : Tidak Aktif</li>
                                        @endif
                                    </ul>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-4 px-4">
                <div class="list-group list-group-flush bg-white p-2 min-vh-10">
                    <a href="/contents/new/form" class="list-group-item fw-semibold text-decoration-none text-dark">Berita
                        Baru</a>
                    <a href="/contents/carousel"
                        class="list-group-item fw-semibold text-decoration-none text-dark">Carousel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
