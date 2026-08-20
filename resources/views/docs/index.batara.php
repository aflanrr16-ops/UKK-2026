@extends('layouts.app')

@section('title', 'Docs — Login Multi-Role')

@section('content')

    <div class="row g-4">
        <div class="col-lg-3 d-none d-lg-block">
            <div class="list-group sticky-top" style="top: 90px;">
                @foreach ($sections as $section)
                    <a class="list-group-item list-group-item-action border-0 px-2 py-1 small" href="#{{ $section['id'] }}">{{ $section['title'] }}</a>
                @endforeach
            </div>
        </div>

        <div class="col-lg-9">
            <div class="mb-4">
                <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">Tutorial</span>
                <h1 class="h3 mb-2">Login Multi-Role di Batara</h1>
                <p class="text-secondary mb-0">Langkah demi langkah membuat login dengan beberapa role (admin, staff, user) memakai Session, Middleware, dan Route::group() bawaan Batara.</p>
            </div>

            @foreach ($sections as $section)
                <section id="{{ $section['id'] }}" class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-semibold mb-3">{{ $section['title'] }}</h2>

                        @foreach ($section['parts'] as $part)
                            @isset ($part['p'])
                                <p class="mb-3">{{ $part['p'] }}</p>
                            @endisset

                            @isset ($part['note'])
                                <div class="alert alert-warning small mb-3">{{ $part['note'] }}</div>
                            @endisset

                            @isset ($part['code'])
                                <pre class="code mb-3">{{ $part['code'] }}</pre>
                            @endisset

                            @isset ($part['table'])
                                <div class="table-responsive mb-3">
                                    <table class="table table-sm align-middle">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Role</th>
                                                <th>Redirect setelah login</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($part['table'] as $baris)
                                                <tr>
                                                    <td><code class="inline">{{ $baris['username'] }}</code></td>
                                                    <td><code class="inline">{{ $baris['password'] }}</code></td>
                                                    <td>{{ $baris['role'] }}</td>
                                                    <td><code class="inline">{{ $baris['tujuan'] }}</code></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endisset
                        @endforeach
                    </div>
                </section>
            @endforeach

            <div class="d-flex gap-2">
                <a class="btn btn-brand" href="{{ route('login') }}">Coba login sekarang</a>
                <a class="btn btn-outline-secondary" href="{{ route('home') }}">Kembali ke beranda</a>
            </div>
        </div>
    </div>

@endsection
