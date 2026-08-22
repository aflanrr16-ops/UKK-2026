@extends('layouts.app')

@section('title', 'User')

@section('content')

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">Area User</span>
            <h1 class="h4 mb-2">Halo, {{ $user->username }}</h1>
            <p class="text-secondary mb-0">Halaman ini hanya bisa diakses role <code class="inline">user</code> (middleware <code class="inline">user</code>).</p>
        </div>
    </div>

@endsection

