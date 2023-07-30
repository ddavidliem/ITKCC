@extends('layouts.app')

@section('content')
    <div>
        <form action="/submit-reset-password" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div>
                <label for="">Email</label>
                <div>
                    <input type="email" class="" name="email">
                </div>
                @if ($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div>
                <label for="">Password</label>
                <div>
                    <input type="password" class="" name="reset_password" id="reset_password">
                </div>
                @if ($errors->has('reset_password'))
                    <div class="error">{{ $errors->first('reset_password') }}</div>
                @endif
            </div>
            <div>
                <label for="">Password Confirmation</label>
                <div>
                    <input type="password" name="reset_password_confirmation" id="reset_password_confirmation">
                </div>
                @if ($errors->has('reset_password_confirmation'))
                    <div class="error">{{ $errors->first('reset_password_confirmation') }}</div>
                @endif
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
@endsection

@push('script')
@endpush
