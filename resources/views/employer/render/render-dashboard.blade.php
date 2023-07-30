<div>
    @if ($loker->isEmpty())
        @include('component.empty')
    @else
        @foreach ($loker as $item)
            <div class="p-4 my-3 rounded border d-flex justify-content-between">
                <img src="{{ asset('poster/' . $item->poster) }}" style="width:200px; height:200px" alt="">
                <div class="align-items-center">
                    <h5 class="text-capitalize">{{ $item->nama_pekerjaan }}</h5>
                    <div class="">
                        <ul class="list-unstyled">
                            <li class="mb-2"> Created At
                                <ul class="list-unstyled">
                                    <li>{{ $item->created_at }}</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <a href="/loker-detail/{{ $item->id }}" class="px-4 py-2 btn btn-info">
                        <h4>Detail</h4>
                    </a>
                </div>

            </div>
        @endforeach
    @endif
</div>
