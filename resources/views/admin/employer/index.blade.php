@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="">
            <div class=" bg-white rounded border-1 min-vh-10 p-4 d-flex">
                <h4 class="fw-semibold col-lg-6">Employer</h4>
                <div class="col-lg-6">
                    <form action="" method="post">
                        @csrf
                        <input type="text" class="form-control" placeholder="Search Employer" id="search">
                    </form>
                </div>
            </div>
            <div class="my-4">
                <div class="bg-white rounded min-vh-100 border-1">
                    <div class="d-flex">
                        <div class="col-lg-3">
                            <div class="max-vh-100 overflow-auto list-group list-group-flush">
                                @foreach ($employer as $item)
                                    <a href="" class="list-group-item p-4">

                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-9 px-2">
                            <div class="max-vh-100 overflow-auto p-4">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        $('#search').on('keyup', function(){
            search();
        });
        search();

        function search(){
            var keyword = $('#search').val();
            $.post('{{ route("employee.search") }}',
            {_token: $('meta[name="csrf-token"]').attr('content'),keyword:keyword},
            function(data){
                table_post_row(data);
        });
}
    </script>
@endpush
