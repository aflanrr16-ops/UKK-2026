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

@include('partials.navbar')

<main class="container flex-grow-1 py-4 py-lg-5">
    @include('partials.flash')

    @yield('content')
</main>

@include('partials.footer')

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@yield('scripts')

</body>
</html>
