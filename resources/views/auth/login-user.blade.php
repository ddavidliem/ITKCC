@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="row col-md-4  shadow-lg p-5 mt-4 text-capitalize">
            <h1 class="text-center">user login</h1>
            <form action="/login-user" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="mb-3 row">
                        <label for="" class="form-label">username / email</label>
                        <div class="col-12">
                            <input class="form-control" type="text" name="username" placeholder="username">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="password">
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary col-12 mb-3 ">Sign In</button>
                    <a href="/forget-password" class="btn btn-info mb-3 col-12">Lupa Password</a>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('script')
    <script type="module">

    </script>
@endpush
