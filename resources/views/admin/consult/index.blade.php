@extends('layouts.user')

@section('content')
    <div class="container py-4">
        <div class="min-vh-100 bg-white rounded p-4">
            <img src="{{ asset('component/coaching-clinic.png') }}" class="img-fluid" alt="">
            <div class="py-4 d-flex justify-content-center">
                <div class="col-3 p-4 border border-dark">
                    <h5 class="text-center fw-bold">Konsultasi Pribadi</h5>
                    <div class="mt-4">
                        <p>Konsultasi pribadi Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                            roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.
                            Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia,</p>
                    </div>

                </div>
                <div class="col-3 mx-2 p-4 border border-dark">
                    <h5 class="text-center fw-bold">Konsultasi Kelompok</h5>
                    <div class="mt-4">
                        <p>Konsultasi kelompok/bersama Contrary to popular belief, Lorem Ipsum is not simply random text. It
                            has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.
                            Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia</p>
                    </div>
                </div>
                <div class="col-3 p-4 border border-dark">
                    <h5 class="text-center fw-bold">Konsultasi Karir</h5>
                    <div class="mt-4">
                        <p>Konsultasi Karir Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                            in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard
                            McClintock, a Latin professor at Hampden-Sydney College in Virginia</p>
                    </div>
                </div>
            </div>
            <div class="py-4 d-flex justify-content-center ">
                <div class="col-9 border border-dark p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="fw-bold ">Jam Layanan Coaching Clinic</h5>
                            <h6>Senin - Jumat</h6>
                            <h6>Jam 08.00 - 15.00 WITA</h6>
                        </div>
                        <div class="d-flex">
                            <a href="/konsultasi/formulir" type="button"
                                class="fs-5 btn btn-outline-dark align-self-center">Make Appointment</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
