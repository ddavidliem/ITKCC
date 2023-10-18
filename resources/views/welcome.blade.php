@extends('layouts.app')

@section('content')
    <div id="carouselITKCC" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselITKCC" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselITKCC" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselITKCC" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" id="carousel-inner">
            @foreach ($carousel as $item)
                <div class="carousel-item active">
                    <img src="{{ asset('content/' . $item->image) }}" class="img-fluid w-100" alt="...">
                    @if ($item->body)
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselITKCC" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselITKCC" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <div class="my-5">
        <h4 class="text-center">Follow Our Instagram Page</h4>
        <div class="d-flex justify-content-center my-2">
            <div class="align-content-center border-2 rounded shadow-sm p-2 mx-2">
                <div class="text-center">
                    <img src="{{ asset('img/instagram-page.png') }}" alt="" width="700" height="271">
                </div>
            </div>
        </div>
    </div>
@endsection
