<?php

namespace App\Controllers\Core;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use App\Models\Alat;
use Sakuci\Http\Request;

class DashboardController
{
    /**
     * 1. FUNGSI UTAMA / REDIRECT DINAMIS (TANPA HARDCODE IF-ELSE)
     * Mengarahkan user dari beranda langsung ke URL dashboard role mereka masing-masing
     */
    public function index(Request $request)
    {
        $user = User::current();

        if (!$user) {
            return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil nama role user (contoh: 'admin', 'petugas', 'peminjam')
        $rolePath = strtolower($user->role ?? '');
        
        // Redirect dinamis ke URL sesuai rolenya tanpa perlu hardcode if-else
        // Contoh: Jika role admin, akan otomatis redirect ke '/admin'
        return redirect('/' . $rolePath);
    }

    /**
     * 2. DASHBOARD KHUSUS ADMIN
     */
    public function admin(Request $request)
    {
        $user = User::current();
        if (!$user) return redirect(route('login'));

        $totalUser        = class_exists(User::class) ? User::count() : 0;
        $totalAlat        = class_exists(Alat::class) ? Alat::count() : 0;
        $totalPeminjaman  = class_exists(Peminjaman::class) ? Peminjaman::count() : 0;
        $totalPengembalian= class_exists(Pengembalian::class) ? Pengembalian::count() : 0;

        return view('core.admin.dashboard', compact(
            'user', 'totalUser', 'totalAlat', 'totalPeminjaman', 'totalPengembalian'
        ));
    }

    /**
     * 3. DASHBOARD KHUSUS PETUGAS
     */
    public function petugas(Request $request)
    {
        $user = User::current();
        if (!$user) return redirect(route('login'));

        $semuaPeminjaman = class_exists(Peminjaman::class) ? Peminjaman::all() : [];
        
        $pendingCount   = 0;
        $activeCount    = 0;
        $completedCount = 0;

        foreach ($semuaPeminjaman as $p) {
            $st = strtolower($p->status);
            if ($st === 'pending' || $st === 'menunggu') $pendingCount++;
            elseif ($st === 'dipinjam' || $st === 'disetujui') $activeCount++;
            elseif ($st === 'dikembalikan' || $st === 'selesai') $completedCount++;
        }

        return view('petugas.dashboard', compact('user', 'pendingCount', 'activeCount', 'completedCount'));
    }

    /**
     * 4. DASHBOARD KHUSUS PEMINJAM / SISWA
     */
    public function peminjam(Request $request)
    {
        $user = User::current();
        if (!$user) return redirect(route('login'));

        $userId = $user->id ?? $user->id_user ?? null;
        $peminjamanUser = Peminjaman::where('id_user', $userId)->get();

        $pendingCount   = 0;
        $activeCount    = 0;
        $completedCount = 0;
        $totalDenda     = 0;

        foreach ($peminjamanUser as $p) {
            $st = strtolower($p->status);
            if ($st === 'pending' || $st === 'menunggu') $pendingCount++;
            elseif ($st === 'dipinjam' || $st === 'disetujui') $activeCount++;
            elseif ($st === 'dikembalikan' || $st === 'selesai') $completedCount++;

            if (!empty($p->denda)) $totalDenda += (int) $p->denda;

            if (class_exists(Pengembalian::class)) {
                $pengembalian = Pengembalian::where('id_peminjaman', $p->id_peminjaman)->first();
                if ($pengembalian && !empty($pengembalian->denda)) {
                    $totalDenda += (int) $pengembalian->denda;
                }
            }
        }

        $viewName = file_exists(base_path('resources/views/peminjam/dashboard.sakuci.php')) 
                    ? 'peminjam.dashboard' 
                    : 'dashboard';

        return view($viewName, compact('user', 'pendingCount', 'activeCount', 'completedCount', 'totalDenda'));
    }
}