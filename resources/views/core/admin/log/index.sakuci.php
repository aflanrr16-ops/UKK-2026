@extends('layouts.app')

@section('title', config('app.name') . ' -- Log Aktifitas Admin')

@section('content')
<div class="container-fluid py-4 px-4">
    
    <!-- Header Halaman -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold mb-1 tracking-tight">Log Aktifitas Admin</h3>
            <p class="text-body-secondary small mb-0">Riwayat catatan aktifitas dan tindakan yang dilakukan dalam sistem.</p>
        </div>
    </div>

    <!-- Card Pembungkus Tabel yang Seragam -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary border-bottom text-body-secondary text-uppercase fs-8 tracking-wider">
                        <tr>
                            <th class="py-3 px-4 text-center" style="width: 5%;">No</th>
                            <th class="py-3 px-3">Admin/Peminjam/Petugas</th>
                            <th class="py-3 px-3">Aktifitas / Keterangan</th>
                            <th class="py-3 px-3" style="width: 25%;">Waktu Kejadian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($datap as $log)
                        @php
                            // Mengambil nama user secara aman berdasarkan id_user
                            $userIdVal = $log->id_user ?? null;
                            $userObj = $userIdVal ? \App\Models\User::find($userIdVal) : null;
                            $namaUser = $userObj->name ?? $userObj->nama ?? $userObj->username ?? ('User ID: ' . ($userIdVal ?? 'Sistem'));
                        @endphp
                        <tr>
                            <td class="px-4 text-center text-body-secondary fw-medium fs-7">{{ $no++ }}</td>
                            
                            <td class="px-3">
                                <div class="fw-semibold text-body fs-7">
                                    <i class="bi bi-person-badge text-primary me-1"></i> {{ $namaUser }}
                                </div>
                            </td>

                            <td class="px-3">
                                <span class="text-body fs-7">{{ $log->aktifitas ?? '-' }}</span>
                            </td>

                            <td class="px-3">
                                <span class="badge bg-body-tertiary text-body border font-monospace fw-semibold px-2.5 py-1.5 rounded-2 fs-8">
                                    <i class="bi bi-clock me-1"></i> {{ $log->created_at ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-body-secondary">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-journal-x fs-2 opacity-50"></i>
                                    <span class="fs-7">Belum ada catatan log aktifitas yang terekam.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Bagian Pagination -->
        @if(method_exists($datap, 'hasPages') && $datap->hasPages())
        <div class="card-footer bg-transparent py-3 border-top-0 d-flex justify-content-end">
            {!! $datap->links() !!}
        </div>
        @endif
    </div>

</div>
@endsection