@foreach ($carousel as $item)
    <div class="carousel-item">
        <img src="{{ asset('content/' . $item->image) }}" class="d-block img-fluid w-100" alt="...">
        @if ($item->body)
            <div class="carousel-caption d-none d-md-block">
                <h5>First slide label</h5>
                <p>Some representative placeholder content for the first slide.</p>
            </div>
        @endif
    </div>
@endforeach
