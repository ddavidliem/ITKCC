@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible alert-block fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible alert-block" role="alert">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible alert-block" role="alert">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible alert-block" role="alert">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif
{{-- @if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-bs-dismiss="alert">×</button>
        Check the following errors :(
    </div>
@endif --}}
@if ($message = Session::get('empty'))
    <div>
        <h4>Empty Notification</h4>
    </div>
@endif
