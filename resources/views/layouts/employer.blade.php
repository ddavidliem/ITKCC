<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ITKCC</title>
    @stack('style')
    @vite(['resources/js/app.js'])
</head>

<body class="bg-white">

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav nav-list me-auto mb-2 mb-lg-10">
                        <li class="nav-item">
                            <a href="/" class="fw-bold nav-link :hover">Home</a>
                        </li>
                        @auth('employer')
                            <li class="nav-item">
                                <a href="/Employer/Dashboard" class="fw-bold nav-link :hover">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="/Employer/Profile" class="fw-bold nav-link :hover">Profile</a>
                            </li>
                        @endauth
                    </ul>
                    <ul class="navbar-nav me-a mb-2 mb-lg-10">

                        @guest('employer')
                            <li class="nav-item dropdown container">
                                <a href="" class="nav-link dropdown-toggle" role="button"
                                    data-bs-toggle="dropdown">Sign Up</a>
                                <ul class="dropdown-menu">
                                    <li><a href="/register-employer" class="dropdown-item">Register Employer</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown container">
                                <a href="" class="nav-link dropdown-toggle" role="button"
                                    data-bs-toggle="dropdown">Login</a>
                                <ul class="dropdown-menu">
                                    <li><a href="/employer-login-form" class="dropdown-item">Login Employer</a></li>
                                </ul>
                            </li>
                        @endguest

                        @auth('employer')
                            <li class="nav-item">
                                <a href="/logout-employer" class="fw-bold nav-link :hover">Logout</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="min-vh-100 bg-secondary bg-opacity-10 ">
            @include('flash-message')
            @yield('content')
        </main>

        <footer class="container p-2 d-flex justify-content-between align-content-center">
            <div class="mx-5 p-2 text-capitalize">
                <h5>contact information</h5>
                <div class="my-2 p-1">
                    <ul>
                        <li><span class="text-bold">Address</span> : </li>
                        <li><span class="text-bold">Phone</span>: </li>
                        <li><span class="text-bold">Email</span> : </li>
                    </ul>
                </div>
            </div>
            <div class="mx-5 p-2">
                <h5>About Us</h5>
                <div class="my-2 p-1">
                    <p>ITK Career Center merupakan pusat layanan dan Karir bagi Alumni Institut Teknologi Kalimantan,
                        kami menyediakan <br>
                        informasi karir, pemagangan dan lowongan kerja diberbagai bidang dan lintas perusahaan industri
                    </p>
                </div>
            </div>
            <div class="mx-5 p-2">
                <h5>External Link</h5>
                <div class="my-2 p-1">
                    <ul class="list-unstyled">
                        {{-- <li><a href="/login-admin" class=" text-decoration-none">Admin</a></li> --}}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    @stack('script')
</body>


</html>
