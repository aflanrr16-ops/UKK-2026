<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Alat;
use App\Models\LogAktifitas;

class PengembalianController extends Controller
{
    // =========================================================================
    // BAGIAN 1: KHUSUS ADMIN (FULL AKSES KELOLA)
    // =========================================================================

    public function index(Request $request)
    {
        $datap = Pengembalian::orderBy('id_pengembalian', 'desc')->paginate(10);
        $peminjaman = Peminjaman::all();
        $users = User::all();
        $alats = Alat::all();

        $peminjamanList = [];
        foreach ($peminjaman as $p) {
            $pid = $p->id_peminjaman ?? $p->id;
            $peminjamanList[$pid] = $p;
        }

        $userList = [];
        foreach ($users as $u) {
            $id = $u->id ?? $u->id_user;
            $userList[$id] = $u->username ?? $u->nama ?? "User #{$id}";
        }

        $alatList = [];
        foreach ($alats as $a) {
            $id = $a->id_alat ?? $a->id;
            $alatList[$id] = $a->nama_alat ?? "Alat #{$id}";
        }

        return view('pengembalian.index', compact('datap', 'peminjamanList', 'userList', 'alatList'));
    }

    public function create(Request $request)
    {
        $peminjaman = Peminjaman::where('status', '!=', 'Dikembalikan')->get();
        $users = User::all();
        $alats = Alat::all();

        $userList = [];
        foreach ($users as $u) {
            $id = $u->id ?? $u->id_user;
            $userList[$id] = $u->username ?? $u->nama ?? "User #{$id}";
        }

        $alatList = [];
        foreach ($alats as $a) {
            $id = $a->id_alat ?? $a->id;
            $alatList[$id] = $a->nama_alat ?? "Alat #{$id}";
        }

        return view('pengembalian.create', compact('peminjaman', 'userList', 'alatList'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_peminjaman'        => 'required|integer',
            'tanggal_pengembalian' => 'required|date',
            'kondisi_barang'       => 'nullable|string|max:100',
            'catatan'              => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($validatedData['id_peminjaman']);
        $tglJatuhTempo = $peminjaman->tanggal_kembali ?? $peminjaman->tanggal_selesai ?? date('Y-m-d');

        $tglRencana = new \DateTime($tglJatuhTempo);
        $tglAktual = new \DateTime($validatedData['tanggal_pengembalian']);
        
        $tglRencana->setTime(0, 0, 0);
        $tglAktual->setTime(0, 0, 0);

        $selisihHari = 0;
        $denda = 0;

        if ($tglAktual > $tglRencana) {
            $interval = $tglRencana->diff($tglAktual);
            $selisihHari = $interval->days;
            $tarifDendaPerHari = 2000; 
            $denda = $selisihHari * $tarifDendaPerHari;
        }

        $validatedData['terlambat_hari'] = $selisihHari;
        $validatedData['denda']          = $denda;
        $validatedData['kondisi_barang'] = $validatedData['kondisi_barang'] ?? 'Baik';

        Pengembalian::create($validatedData);
        $peminjaman->update(['status' => 'Dikembalikan']);

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Admin mencatat pengembalian alat (Peminjaman ID: ' . $validatedData['id_peminjaman'] . '). Terlambat: ' . $selisihHari . ' hari.'
        ]);

        return redirect(route('pengembalian.index'))->with('success', 'Data pengembalian berhasil ditambahkan. Terlambat: ' . $selisihHari . ' hari, Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    public function edit(Request $request, $id_pengembalian)
    {
        $datap = Pengembalian::findOrFail($id_pengembalian);
        $peminjaman = Peminjaman::find($datap->id_peminjaman);

        $peminjamName = '-';
        $alatName = '-';

        if ($peminjaman) {
            $user = User::find($peminjaman->id_user);
            $alat = Alat::find($peminjaman->id_alat);
            if (!$alat) {
                $alat = Alat::where('id_alat', $peminjaman->id_alat)->first();
            }

            $peminjamName = $user->username ?? $user->nama ?? ("User #" . $peminjaman->id_user);
            $alatName = $alat->nama_alat ?? ("Alat #" . $peminjaman->id_alat);
        }

        return view('pengembalian.edit', compact('datap', 'peminjaman', 'peminjamName', 'alatName'));
    }

    public function update(Request $request, $id_pengembalian)
    {
        $validatedData = $request->validate([
            'id_peminjaman'        => 'required|integer',
            'tanggal_pengembalian' => 'required|date',
            'kondisi_barang'       => 'nullable|string|max:100',
            'catatan'              => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($validatedData['id_peminjaman']);
        $tglJatuhTempo = $peminjaman->tanggal_kembali ?? $peminjaman->tanggal_selesai ?? date('Y-m-d');

        $tglRencana = new \DateTime($tglJatuhTempo);
        $tglAktual = new \DateTime($validatedData['tanggal_pengembalian']);
        
        $tglRencana->setTime(0, 0, 0);
        $tglAktual->setTime(0, 0, 0);

        $selisihHari = 0;
        $denda = 0;

        if ($tglAktual > $tglRencana) {
            $interval = $tglRencana->diff($tglAktual);
            $selisihHari = $interval->days;
            $tarifDendaPerHari = 2000; 
            $denda = $selisihHari * $tarifDendaPerHari;
        }

        $validatedData['terlambat_hari'] = $selisihHari;
        $validatedData['denda']          = $denda;

        $pengembalian = Pengembalian::findOrFail($id_pengembalian);
        $pengembalian->update($validatedData);

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Admin memperbarui data pengembalian (ID: ' . $id_pengembalian . ').'
        ]);

        return redirect(route('pengembalian.index'))->with('success', 'Data pengembalian berhasil diubah.');
    }

    public function delete(Request $request, $id_pengembalian)
    {
        $pengembalian = Pengembalian::findOrFail($id_pengembalian);
        $pengembalian->delete();

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Admin menghapus data pengembalian (ID: ' . $id_pengembalian . ').'
        ]);

        return redirect(route('pengembalian.index'))->with('success', 'Data pengembalian berhasil dihapus.');
    }


    // =========================================================================
    // BAGIAN 2: KHUSUS ROLE PEMINJAM (SISWA)
    // =========================================================================

    public function createPeminjam(Request $request)
    {
        $user = User::current();
        if (!$user) return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');

        $id_user = $user->id ?? $user->id_user;
        $peminjamanAktif = Peminjaman::where('id_user', $id_user)
                                     ->whereIn('status', ['Dipinjam', 'Disetujui', 'dipinjam', 'disetujui'])
                                     ->get();

        foreach ($peminjamanAktif as $p) {
            $p->alat = Alat::where('id_alat', $p->id_alat)->first();
        }

        return view('peminjam.pengembalian', compact('user', 'peminjamanAktif'));
    }

    public function storePeminjam(Request $request)
    {
        $currentUser = User::current();
        if (!$currentUser) return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');

        $validatedData = $request->validate([
            'id_peminjaman'        => 'required|integer',
            'tanggal_pengembalian' => 'required|date',
            'kondisi_barang'       => 'nullable|string|max:100',
            'catatan'              => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($validatedData['id_peminjaman']);
        $tglJatuhTempo = $peminjaman->tanggal_kembali ?? $peminjaman->tanggal_selesai ?? date('Y-m-d');

        $tglRencana = new \DateTime($tglJatuhTempo);
        $tglAktual = new \DateTime($validatedData['tanggal_pengembalian']);
        
        $tglRencana->setTime(0, 0, 0);
        $tglAktual->setTime(0, 0, 0);

        $selisihHari = 0;
        $denda = 0;

        if ($tglAktual > $tglRencana) {
            $interval = $tglRencana->diff($tglAktual);
            $selisihHari = $interval->days;
            $denda = $selisihHari * 2000;
        }

        $validatedData['terlambat_hari'] = $selisihHari;
        $validatedData['denda']          = $denda;
        $validatedData['kondisi_barang'] = $validatedData['kondisi_barang'] ?? 'Baik';

        // Simpan input siswa ke tabel pengembalian (agar kondisi & catatan tersimpan)
        $existingPengembalian = Pengembalian::where('id_peminjaman', $validatedData['id_peminjaman'])->first();
        if ($existingPengembalian) {
            $existingPengembalian->update($validatedData);
        } else {
            Pengembalian::create($validatedData);
        }
        
        // Ubah status peminjaman menjadi 'Menunggu Pengembalian'
        $peminjaman->update(['status' => 'Menunggu Pengembalian']);

        LogAktifitas::create([
            'id_user'   => $currentUser->id,
            'aktifitas' => 'Peminjam ' . ($currentUser->username ?? 'Siswa') . ' mengajukan pengembalian alat.'
        ]);

        return redirect(route('peminjam.riwayat'))->with('success', 'Pengajuan pengembalian berhasil dikirim. Menunggu verifikasi petugas.');
    }


    // =========================================================================
    // BAGIAN 3: KHUSUS ROLE PETUGAS (PANTAU & CETAK LAPORAN)
    // =========================================================================

    public function indexPetugas(Request $request)
    {
        $user = User::current();
        if (!$user) {
            return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // HANYA TAMPILKAN data pengembalian yang peminjamannya sudah berstatus 'Dikembalikan'
        $validIds = Peminjaman::where('status', 'Dikembalikan')->pluck('id_peminjaman');
        $datap = Pengembalian::whereIn('id_peminjaman', $validIds)->orderBy('id_pengembalian', 'desc')->paginate(10);
        
        $peminjaman = Peminjaman::all();
        $users = User::all();
        $alats = Alat::all();

        $peminjamanList = [];
        foreach ($peminjaman as $p) {
            $pid = $p->id_peminjaman ?? $p->id;
            $peminjamanList[$pid] = $p;
        }

        $userList = [];
        foreach ($users as $u) {
            $id = $u->id ?? $u->id_user;
            $userList[$id] = $u->username ?? $u->nama ?? "User #{$id}";
        }

        $alatList = [];
        foreach ($alats as $a) {
            $id = $a->id_alat ?? $a->id;
            $alatList[$id] = $a->nama_alat ?? "Alat #{$id}";
        }

        return view('petugas.pantau_pengembalian', compact('datap', 'peminjamanList', 'userList', 'alatList'));
    }

    public function cetakPetugas(Request $request)
    {
        $user = User::current();
        if (!$user) {
            return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $validIds = Peminjaman::where('status', 'Dikembalikan')->pluck('id_peminjaman');
        $datap = Pengembalian::whereIn('id_peminjaman', $validIds)->orderBy('id_pengembalian', 'desc')->get();
        
        $peminjaman = Peminjaman::all();
        $users = User::all();
        $alats = Alat::all();

        $peminjamanList = [];
        foreach ($peminjaman as $p) {
            $pid = $p->id_peminjaman ?? $p->id;
            $peminjamanList[$pid] = $p;
        }

        $userList = [];
        foreach ($users as $u) {
            $id = $u->id ?? $u->id_user;
            $userList[$id] = $u->username ?? $u->nama ?? "User #{$id}";
        }

        $alatList = [];
        foreach ($alats as $a) {
            $id = $a->id_alat ?? $a->id;
            $alatList[$id] = $a->nama_alat ?? "Alat #{$id}";
        }

        return view('petugas.cetak_pengembalian', compact('datap', 'peminjamanList', 'userList', 'alatList', 'user'));
    }
}
