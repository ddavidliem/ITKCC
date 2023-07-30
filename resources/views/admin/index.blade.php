@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="d-flex">
            <div class="col-lg-2">
                <div class="min-vh-25 p-4 bg-white rounded border-1 list-group list-group-flush">
                    <a href="/dashboard" class="list-group-item text-decoration-none fs-6 fw-semibold">
                        Home
                    </a>
                    <a href="/approval" class="list-group-item text-decoration-none fs-6 fw-semibold">
                        Approval
                    </a>
                    <a href="/employer" class="list-group-item text-decoration-none fs-6 fw-semibold">
                        Employer
                    </a>
                    <a href="/user" class="list-group-item text-decoration-none fs-6 fw-semibold">
                        User
                    </a>
                    <a href="/loker" class="list-group-item text-decoration-none fs-6 fw-semibold">
                        Loker
                    </a>
                    <a href="/appointment" class="list-group-item text-decoration-none fs-6 fw-semibold">
                        Appointment
                    </a>
                    <a href="/content" class="list-group-item text-decoration-none fs-6 fw-semibold">
                        Content
                    </a>
                </div>
            </div>

            <div class="col-lg-10 px-4">
                <div class="max-vh-100 overflow-auto p-2">


                    <div class="min-vh-15 p-4 bg-white rounded border-1">
                        <h3 class="">Approval</h3>
                        <div class="d-flex my-4 justify-content-center">
                            <div class="col-lg-3 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">Pending</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $approvalMonthly }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-3 mx-5 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">Approved</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $approved }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-3 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">Review</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $total }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="min-vh-15 p-4 bg-white rounded border-1 my-4">
                        <h3 class="">Appointment</h3>
                        <div class="d-flex my-4 justify-content-center">
                            <div class="col-lg-3 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">Pending</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $pending }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-3 mx-5 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">Complete</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $finish }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="min-vh-25 p-4 bg-white rounded border-1 my-4">
                        <h3>Employer</h3>
                        <div class="d-flex my-4 justify-content-center">
                            <div class="col-lg-3 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">Total Employer</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $employer }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 mx-4 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">This Month New Employer </h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $employerMonthly }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="min-vh-25 p-4 bg-white rounded border-1 my-4">
                        <h3>Loker</h3>
                        <div class="d-flex my-4 justify-content-center">
                            <div class="col-lg-3 shadow min-vh-10 border-1 p-2 d-flex">
                                <h6 class="fw-bold my-2 col-lg-10">Total Loker</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $loker }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-3 shadow min-vh-10 border-1 p-2 d-flex mx-4">
                                <h6 class="fw-bold my-2 col-lg-10">This Month New Loker</h6>
                                <div class="col-lg-2 mt-auto">
                                    <h4>{{ $lokerMonthly }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
