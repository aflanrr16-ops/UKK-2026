<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    {{-- Bootstrap 5.3.8 -- file lokal, tidak butuh internet --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100 bg-body-tertiary">

<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="{{ route('home') }}">
            <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block;">
                <!-- Outer circle border -->
                <circle cx="16" cy="16" r="15" fill="none" stroke="#333" stroke-width="1.5"/>

                <!-- Top half - RED (putih jadi merah) -->
                <path d="M 16 1 A 15 15 0 0 1 16 16 A 7.5 7.5 0 0 1 16 1" fill="#FF0000"/>

                <!-- Bottom half - BLUE (hitam jadi biru) -->
                <path d="M 16 16 A 15 15 0 0 1 16 31 A 7.5 7.5 0 0 1 16 16" fill="#0066FF"/>

                <!-- Top dot - YELLOW (putih dot jadi kuning) -->
                <circle cx="16" cy="8.5" r="2.5" fill="#FFD700"/>

                <!-- Bottom dot - YELLOW (hitam dot jadi kuning) -->
                <circle cx="16" cy="23.5" r="2.5" fill="#FFD700"/>
            </svg>
            {{ config('app.name') }}
        </a>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#menuUtama"
                aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Tambahkan menu aplikasi Anda di sini --}}
        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('docs') }}">Docs</a>
                </li>
                @php
                    $currentUser = \App\Models\User::current();
                @endphp
                @if ($currentUser)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $currentUser->role === 'admin' ? route('admin.dashboard') : ($currentUser->role === 'staff' ? route('staff.dashboard') : route('dashboard')) }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-lg-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100 mt-2 mt-lg-0">Logout ({{ $currentUser->username }})</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-sm btn-outline-brand mt-2 mt-lg-0" href="{{ route('login') }}">Masuk</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main class="container flex-grow-1 py-4 py-lg-5">
    @include('partials.flash')

    @yield('content')
</main>

<footer class="border-top bg-white py-4 mt-auto">
    <div class="container text-center text-secondary small">
        Sakuci Framework &middot; PHP {{ PHP_VERSION }} &middot; Bootstrap 5.3.8 &middot; tanpa Composer
    </div>
</footer>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@yield('scripts')

</body>
</html>
