@extends('layouts.app')

@section('content')
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" id="carousel-inner">

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="my-5">
        <h4 class="text-center">Info Lowongan Terbaru</h4>
        <div class="d-flex justify-content-center mx-2">
            <div class="align-content-center border-2 rounded shadow-sm p-2 mx-2">
                <div class="text-center">
                    <img src="{{ asset('img/info.png') }}" alt="" width="200px" height="200px">
                    <div class="">
                        <h5>Nama Perusahaan</h5>
                    </div>
                </div>
            </div>
            <div class="align-content-center border-2 rounded shadow-sm p-2 mx-2">
                <div class="text-center">
                    <img src="{{ asset('img/info.png') }}" alt="" width="200px" height="200px">
                    <div class="">
                        <h5>Nama Perusahaan</h5>
                    </div>
                </div>
            </div>
            <div class="align-content-center border-2 rounded shadow-sm p-2 mx-2">
                <div class="text-center">
                    <img src="{{ asset('img/info.png') }}" alt="" width="200px" height="200px">
                    <div class="">
                        <h5>Nama Perusahaan</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-5">
        <h4 class="text-center">Pencari Kerja</h4>
        <div class="d-flex justify-content-center my-2">
            <div class="align-content-center border-2 rounded shadow-sm p-4 mx-2">
                <button class="btn">
                    <div class="text-center">
                        <p>Sudah Memiliki Akun ??</p>
                        <h5 class="text-capitalized"><a href="/login/user" class="text-decoration-none text-reset">Sign
                                In User</a>
                        </h5>
                    </div>
                </button>
            </div>
            <div class="align-content-center border-2 rounded shadow-sm p-4 mx-2">
                <button class="btn">
                    <div class="text-center">
                        <p>Belum Memiliki Akun ??</p>
                        <h5 class="text-capitalized"><a href="/register-user-form"
                                class="text-decoration-none text-reset">Sign Up User</a>
                        </h5>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div class="my-5">
        <h4 class="text-center">Penyedia Kerja</h4>
        <div class="d-flex justify-content-center my-2">
            <div class="align-content-center border-2 rounded shadow-sm p-4 mx-2">
                <button class="btn">
                    <div class="text-center">
                        <p>Sudah Memiliki Akun ??</p>
                        <h5 class="text-capitalized"><a href="/employer-login-form"
                                class="text-decoration-none text-reset">Sign In Employer</a>
                        </h5>
                    </div>
                </button>
            </div>
            <div class="align-content-center border-2 rounded shadow-sm p-4 mx-2">
                <button class="btn">
                    <div class="text-center">
                        <p>Belum Memiliki Akun ??</p>
                        <h5 class="text-capitalized"><a href="/register-employer"
                                class="text-decoration-none text-reset">Sign Up Employer</a>
                        </h5>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div class="my-5">
        <h4 class="text-center">Layanan Kami</h4>
        <div class="d-flex justify-content-center my-2">
            <div class="align-content-center border-2 rounded shadow-sm p-2 mx-2">
                <div class="text-center">
                    <img src="{{ asset('img/layanan-1.png') }}" alt="" width="300px" height="300px">
                    <div class="">
                        <h5>Nama Layanan</h5>
                    </div>
                </div>
            </div>
            <div class="align-content-center border-2 rounded shadow-sm p-2 mx-2">
                <div class="text-center">
                    <img src="{{ asset('img/layanan-1.png') }}" alt="" width="300px" height="300px">
                    <div class="">
                        <h5>Nama Layanan</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-5">
        <h4 class="text-center">Follow Our Instagram Page</h4>
        <div class="d-flex justify-content-center my-2">
            <div class="align-content-center border-2 rounded shadow-sm p-2 mx-2">
                <div class="text-center">
                    <img src="{{ asset('img/instagram-page.png') }}" alt="" width="700" height="271">
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script type="module">
        $(document).ready(function () {
            $.ajax({
                type: "Get",
                url: "/carousel",
                dataType: "",
                success: function (response) {
                    $('#carousel-inner').html(response.carousel);
                }
            });
        });
    </script>
@endpush
