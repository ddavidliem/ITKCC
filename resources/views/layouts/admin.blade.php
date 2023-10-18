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
                @auth('admin')
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav nav-list me-auto mb-2 mb-lg-10">
                            <li class="nav-item">
                                <a href="/" class="fw-semibold nav-link :hover">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="/dashboard" class="fw-semibold nav-link :hover">Dashboard</a>
                            </li>
                            <li class="nav-item dropdown container">
                                <a href="" class="nav-link dropdown-toggle fw-semibold" role="button"
                                    data-bs-toggle="dropdown">Menu</a>
                                <ul class="dropdown-menu">
                                    <li><a href="/approval" class="dropdown-item">Approval</a></li>
                                    <li><a href="/appointment" class="dropdown-item">Appointment</a></li>
                                    <li><a href="/employer" class="dropdown-item">Perusahaan</a></li>
                                    <li><a href="/contents" class="dropdown-item">Content</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="navbar-nav me-a mb-2 mb-lg-10">
                            @if (Auth::guard('admin')->check())
                                <a href="/logout-admin" class="dropdown-item">Logout</a>
                            @endif
                        </ul>
                    </div>
                @endauth
            </div>
        </nav>

        <main class="min-vh-100 bg-secondary bg-opacity-10 ">
            <div>
                @include('flash-message')
                @yield('content')
            </div>
        </main>

    </div>
    @stack('script')
</body>


</html>
