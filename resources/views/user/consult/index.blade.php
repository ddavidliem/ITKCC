@extends('layouts.user')

@section('content')

    <div class="container">
        <div class="p-4 d-flex">
            <div class="col-lg-8">
                <div class="p-4 min-vh-100 max-vh-75 overflow-auto bg-white rounded border-1">
                    <h3 class="fw-semibold">Daftar Appointment</h3>
                    @if ($appointment->isEmpty())
                        @include('component.empty')
                    @else
                        <div class="my-4 list-group list-group-flush">
                            @foreach ($appointment as $item)
                                <a href="/Home/User/Appointment/{{ $item->id }}" class="list-group-item p-2 d-flex">
                                    <div class="px-4">
                                        <div>
                                            <h6 class="fw-semibold text-capitalize">{{ $item->topik }}</h6>
                                        </div>
                                        <div>
                                            <ul class=" list-unstyled">
                                                <li class="text-capitalize fw-semibold">{{ $item->jenis_konseling }}</li>
                                                <li class="text-capitalize">{{ $item->tempat_konseling }}</li>
                                                <li class="text-capitalize">Jadwal konseling {{ $item->date_time }}</li>
                                                <li class="">Submitted At {{ $item->created_at }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex ms-auto">
                                        <h6 class="text-capitalize align-self-center">{{ $item->status }}</h6>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 px-2">
                <div class="p-4 min-vh-15 bg-white rounded border-1">
                    <div>
                        <img src="{{ asset('component/coaching-clinic.png') }}" class="img-fluid" alt=""
                            srcset="">
                    </div>
                    <div>
                        Pusat Karir ITK menyediakan layanan coaching clinic untuk membantu kalian menghadapi masalah
                        kehidupan, pekerjaan, ataupun mempersiapkan karir masa depan kalian.
                    </div>
                    <div class="my-4 d-flex justify-content-center">
                        <div>
                            <h6 class="text-center">Ayo Buat Janji Konseling</h6>
                            <a href="/konsultasi/formulir" class="btn btn-outline-dark fs-5">Make Appointment</a>
                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>
@endsection
