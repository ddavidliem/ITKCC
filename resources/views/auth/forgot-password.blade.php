@extends('layouts.app')

@section('content')
    <div>
        <form action="/forget-password" method="POST">
            @csrf
            <div>
                <label for="">Email</label>
                <div>
                    <input type="email" placeholder="Email" name="email">
                </div>
                @if ($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <button class="btn">
                Send Reset Password Link
            </button>
        </form>
    </div>
@endsection

@push('script')
@endpush
