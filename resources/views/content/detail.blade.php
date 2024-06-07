@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="max-vh-100 min-vh-100 overflow-auto bg-white p-4">
            <div class="px-4">
                <h4 class="fw-semibold text-capitalize">{{ $content->title }}</h4>
                <label for="" class="form-label">{{ $content->created_at->format('d-M-Y') }} | Tim Pusat Karir
                    Institut Teknologi Kalimantan</label>
            </div>
            @if ($content->image)
                <div class="d-flex justify-content-center my-4 p-4">
                    <img src="{{ asset('content/' . $content->image) }}" class="img-fluid max-vh-50" alt="">
                </div>
            @endif
            <div class="my-4 p-4 text-wrap">
                <p>{{ $content->body }}</p>
            </div>
        </div>
    </div>
@endsection
