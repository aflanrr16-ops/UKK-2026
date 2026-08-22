@extends('layouts.app')

@section('title', 'Manage Role')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <span class="badge rounded-pill badge-brand px-3 py-2 mb-2">Area Admin</span>
            <h1 class="h4 mb-0">Manage Role</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">&larr; Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 mb-3">Tambah Role Baru</h2>

                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="name">Nama Role</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control {{ errors()->has('name') ? 'is-invalid' : '' }}" placeholder="mis. editor" autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-brand w-100" type="submit">Tambah Role</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h6 mb-3">Daftar Role</h2>

                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td><code class="inline">{{ $role->name }}</code></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-secondary">Belum ada role.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

