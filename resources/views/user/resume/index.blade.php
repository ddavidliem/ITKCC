@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="d-flex justify-content-between">
            <div class="col-lg-3">
                <div class="bg-white rounded min-vh-10 p-4 list-group list-group-flush mb-4">
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#uploadResumeModal">
                        Update Resume
                    </button>
                </div>
                <div class="bg-white rounded min-vh-25 p-4 ">
                    <small class="fs-5 fw-semibold ">Job Seeker Guidance</small>
                    <br>
                    <small>Tim Coaching Clinic ITK menyediakan layanan konsultasi untuk kamu yang masih bingung membuat
                        resume maupun persiapan wawancara kerja</small>
                    <div class="my-4 d-flex justify-content-center">
                        <a href="/appointment-form" class="fs-5 btn btn-primary">Buat Jadwal Konsultasi</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 px-2">
                <div class="col-lg-12 bg-white rounded p-4">
                    <div class="modal fade" id="uploadResumeModal" tabindex="-1" aria-labelledby="uploadResumeModal"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="uploadResumeModal">Form Upload Resume</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="/update-resume" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <h2 class="text-capitalize text-center">Upload File Resume</h2>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="resume"
                                                aria-describedby="resume" aria-label="Upload" name="resume" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div>
                        @if ($user->resume)
                            <div class="">
                                <h3 class="text-center text-capitalize fw-semibold">Resume</h3>
                            </div>
                            <div class="d-flex justify-content-center">
                                <iframe src="{{ asset('resume/' . $user->resume) }}" frameborder="0" class="my-4"
                                    width="100%" height="600px"></iframe>
                            </div>
                        @else
                            @include('component.empty')
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
