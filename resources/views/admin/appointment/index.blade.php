@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="d-flex min-vh-50">
            <div class="col-lg-2">
                <div class="bg-white rounded border-1 p-4 min-vh-15 list-group list-group-flush">
                    <a href="/appointment/schedule" class="list-group-item fw-semibold p-2">Jadwal Konseling</a>
                    <a href="/appointment" class="list-group-item fw-semibold p-2">Appointment</a>
                </div>

            </div>
            <div class="col-lg-8 px-2">
                <div class="bg-white rounded border-1 p-4 min-vh-50 max-vh-100">
                    <h3 class="fw-semibold">Jadwal Konseling</h3>
                    <div id="calendar">
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="bg-white rounded border-1 p-4 min-vh-25 list-group list-group-flush">
                    <a href=""></a>
                    <a href=""></a>
                </div>
            </div>
        </div>
        <div class="p-4">
            <div class="p-4 min-vh-50 bg-white rounded col-lg-10 offset-1">
                <div class="p-4">
                    <table class="table table-hover">
                        <thead>
                            
                        </thead>
                        <tbody class="">
                            {{-- @foreach ($ as $item)
                                <tr></tr>
                            @endforeach --}}
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script type="module">
        
        </script>
@endpush
