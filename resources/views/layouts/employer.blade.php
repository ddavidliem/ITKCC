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
                        @auth('employer')
                            <li class="nav-item">
                                <a href="{{ Route('employer.index') }}" class="fw-bold nav-link :hover">Dashboard</a>
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
                                <a href="{{ Route('employer.logout') }}" class="fw-bold nav-link :hover">Logout</a>
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

        <footer class="container p-2 d-flex justify-content-between">
            @include('component.footer')
        </footer>
    </div>
    @stack('script')
</body>


</html>
