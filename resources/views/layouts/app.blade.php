<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Book Project')</title>
    <link rel="icon" type="image/png" href="../images/book.png">
    <!-- Styles and scripts -->
    @stack('styles')
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="sidebar-mini layout-fixed">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold " href="{{ url('/') }}">Bookie</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                <!-- Left Side -->
                <!-- Left Side -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>


                {{-- Uncomment to enable search
                <form action="{{ route('search') }}" method="GET" class="d-flex me-3" role="search" autocomplete="off">
                    <input class="form-control me-2" type="search" name="query" placeholder="Search books..." aria-label="Search" />
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
                --}}

                <!-- Right Side -->
                <ul class="navbar-nav">
                    @auth
                        @if (Auth::user()->hasRole('admin'))
                            <li class="nav-item me-4 d-flex align-items-center">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">
                                    Go to Admin Dashboard
                                </a>
                            </li>
                        @endif
                    @endauth

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @if (Route::has('register'))
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5 py-5 text-white">
        <div class="container">
            <div class="row gy-4">

                <div class="col-md-4">
                    <h5 class="mb-3">BookBlog</h5>
                    <p>© {{ date('Y') }} BookBlog. All rights reserved.</p>
                    <p>Your go-to destination for book lovers, reviews, and recommendations.</p>
                </div>

                <div class="col-md-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="footer-link">Home</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5 class="mb-3">Follow Us</h5>
                    <a href="https://www.facebook.com/" class="text-white me-3 footer-icon"><i
                            class="fab fa-facebook fa-lg"></i></a>
                    <a href="https://instagram.com/" class="text-white me-3 footer-icon"><i
                            class="fab fa-instagram fa-lg"></i></a>
                    <a href="https://www.whatsapp.com/" class="text-white me-3 footer-icon"><i
                            class="fab fa-whatsapp fa-lg"></i></a>
                </div>

            </div>
        </div>


        <!-- Add FontAwesome for social icons -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
