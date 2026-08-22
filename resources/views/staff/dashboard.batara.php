@extends('layouts.app')

@section('title', 'Staff')

@section('content')

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">Area Staff</span>
            <h1 class="h4 mb-2">Halo, {{ $user->username }}</h1>
            <p class="text-secondary mb-0">Halaman ini bisa diakses role <code class="inline">admin</code> dan <code class="inline">staff</code> (middleware <code class="inline">staff</code>).</p>
        </div>
    </div>

@endsection

