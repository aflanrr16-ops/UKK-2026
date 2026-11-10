<?php

namespace App\Controllers;

use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use App\Models\LogAktifitas;
use Sakuci\Http\Request;

class PeminjamanController
{
    // ==========================================
    // BAGIAN ADMIN: Kelola Semua Peminjaman
    // ==========================================

    public function index(Request $request)
    {
        $datap = Peminjaman::with('pengembalian')
                           ->orderBy('id_peminjaman', 'desc')
                           ->paginate(4);
                           
        return view('peminjaman.index', compact('datap'));
    }

    public function create(Request $request)
    {
        $alat = Alat::all();
        $users = User::all();
        return view('peminjaman.create', compact('alat', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        if (!isset($data['status']) || empty($data['status'])) {
            $data['status'] = 'Pending';
        }

        if (isset($data['status']) && $data['status'] === 'Disetujui') {
            $jumlah = $data['jumlah'] ?? $data['jml'] ?? $data['qty'] ?? 1;
            $alat = Alat::where('id_alat', $data['id_alat'])->first();
            if ($alat) {
                if ($alat->stok <= 0) {
                    return redirect(route('peminjaman.index'))->with('error', 'Gagal! Stok alat ini sudah habis (0 unit).');
                }
                if ($alat->stok < $jumlah) {
                    return redirect(route('peminjaman.index'))->with('error', 'Gagal! Stok tidak mencukupi (Sisa stok: ' . $alat->stok . ').');
                }
                $alat->stok = max(0, $alat->stok - $jumlah);
                $alat->save();
            }
        }

        Peminjaman::create($data);

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Admin menambahkan data peminjaman baru.'
        ]);

        return redirect(route('peminjaman.index'))->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $data = Peminjaman::where('id_peminjaman', $id)->first();
        if (!$data) {
            return redirect(route('peminjaman.index'))->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $alat = Alat::all();
        $users = User::all();
        return view('peminjaman.edit', compact('data', 'alat', 'users'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::where('id_peminjaman', $id)->first();
        if (!$peminjaman) {
            return redirect(route('peminjaman.index'))->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $input = $request->all();
        $statusLama = $peminjaman->status;
        $statusBaru = $input['status'] ?? $statusLama;

        // Stok bertambah jika status diubah menjadi Dikembalikan / Selesai
        if ((strtolower($statusBaru) === 'dikembalikan' || strtolower($statusBaru) === 'selesai') && 
            (strtolower($statusLama) !== 'dikembalikan' && strtolower($statusLama) !== 'selesai')) {
            
            $alat = Alat::where('id_alat', $peminjaman->id_alat)->first();
            if ($alat) {
                $jumlah = $peminjaman->jumlah ?? $peminjaman->jml ?? $peminjaman->qty ?? 1;
                $alat->stok += $jumlah;
                $alat->save();
            }
        }

        if (empty($input['id_alat'])) {
            $input['id_alat'] = $peminjaman->id_alat;
        }
        if (empty($input['id_user'])) {
            $input['id_user'] = $peminjaman->id_user;
        }

        if (!isset($input['denda']) || $input['denda'] === '' || $input['denda'] === null) {
            $input['denda'] = 0;
        }

        $peminjaman->update($input);

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Admin memperbarui data transaksi peminjaman (ID: ' . $id . ').'
        ]);

        return redirect(route('peminjaman.index'))->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function delete(Request $request, $id)
    {
        $peminjaman = Peminjaman::where('id_peminjaman', $id)->first();
        if ($peminjaman) {
            if ($peminjaman->status === 'Disetujui') {
                $alat = Alat::where('id_alat', $peminjaman->id_alat)->first();
                if ($alat) {
                    $jumlah = $peminjaman->jumlah ?? $peminjaman->jml ?? $peminjaman->qty ?? 1;
                    $alat->stok += $jumlah;
                    $alat->save();
                }
            }

            $peminjaman->delete();

            $currentUser = User::current();
            LogAktifitas::create([
                'id_user'   => $currentUser->id ?? null,
                'aktifitas' => 'Admin menghapus data peminjaman (ID: ' . $id . ').'
            ]);
        }

        return redirect(route('peminjaman.index'))->with('success', 'Data peminjaman berhasil dihapus!');
    }


    // ==========================================
    // BAGIAN PEMINJAM / SISWA: Pengajuan Mandiri
    // ==========================================

    public function indexPeminjam(Request $request)
    {
        $currentUser = User::current();
        
        if (!$currentUser) {
            return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $datap = Peminjaman::with('pengembalian')
                           ->where('id_user', $currentUser->id)
                           ->orderBy('id_peminjaman', 'desc')
                           ->paginate(10);

        return view('peminjam.index_peminjam', compact('datap'));
    }

    public function createPeminjam(Request $request)
    {
        $alat = Alat::all();
        return view('peminjam.create_peminjam', compact('alat'));
    }

    public function storePeminjam(Request $request)
    {
        $currentUser = User::current();
        
        if (!$currentUser) {
            return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = $request->all();
        
        $idAlat = $data['id_alat'] ?? null;
        $jumlahDipinjam = $data['jumlah'] ?? $data['jml'] ?? $data['qty'] ?? 1;

        if ($idAlat) {
            $alat = Alat::where('id_alat', $idAlat)->first();
            if ($alat) {
                if ($alat->stok <= 0) {
                    return redirect(route('peminjam.createPeminjam') . '?id_alat=' . $idAlat)->with('error', 'Maaf, stok alat ini sudah habis (0 unit) dan tidak dapat dipinjam.');
                }
                if ($alat->stok < $jumlahDipinjam) {
                    return redirect(route('peminjam.createPeminjam') . '?id_alat=' . $idAlat)->with('error', 'Maaf, jumlah pinjaman melebihi sisa stok yang ada (Sisa stok: ' . $alat->stok . ').');
                }
            }
        }

        $data['id_user'] = $currentUser->id;
        $data['status'] = 'Pending';

        Peminjaman::create($data);

        LogAktifitas::create([
            'id_user'   => $currentUser->id,
            'aktifitas' => 'Peminjam ' . ($currentUser->username ?? 'Siswa') . ' mengajukan permohonan peminjaman alat baru.'
        ]);

        return redirect(route('peminjam.riwayat'))->with('success', 'Pengajuan peminjaman berhasil dikirim dan masuk ke daftar riwayat!');
    }

    public function ajukanPengembalian(Request $request, $id)
    {
        $currentUser = User::current();
        if (!$currentUser) {
            return redirect(route('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $peminjaman = Peminjaman::where('id_peminjaman', $id)
                                ->where('id_user', $currentUser->id)
                                ->first();

        if (!$peminjaman) {
            return redirect(route('peminjam.riwayat'))->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $peminjaman->update([
            'status' => 'Menunggu Pengembalian'
        ]);

        LogAktifitas::create([
            'id_user'   => $currentUser->id,
            'aktifitas' => 'Peminjam mengajukan pengembalian alat untuk transaksi ID: ' . $id
        ]);

        return redirect(route('peminjam.riwayat'))->with('success', 'Pengajuan pengembalian berhasil dikirim. Menunggu verifikasi petugas.');
    }


    // ==========================================
    // BAGIAN PETUGAS: Verifikasi, Persetujuan & Dashboard
    // ==========================================

    public function dashboardPetugas(Request $request)
    {
        $currentUser = User::current();

        $totalPending  = Peminjaman::where('status', 'Pending')->count();
        $totalDipinjam = Peminjaman::where('status', 'Disetujui')->count();
        $totalSelesai  = Peminjaman::where('status', 'Dikembalikan')->count();

        return view('petugas.dashboard', [
            'user'          => $currentUser,
            'totalPending'  => $totalPending,
            'totalDipinjam' => $totalDipinjam,
            'totalSelesai'  => $totalSelesai,
        ]);
    }

    public function indexPetugas(Request $request)
    {
        $datap = Peminjaman::orderBy('id_peminjaman', 'desc')->paginate(10);
        
        foreach ($datap as $item) {
            $item->data_alat = Alat::where('id_alat', $item->id_alat)->first();
            $item->data_user = User::where('id', $item->id_user)->first();
        }

        return view('petugas.peminjaman', compact('datap'));
    }

    public function setujuiPetugas(Request $request, $id)
    {
        $peminjaman = Peminjaman::where('id_peminjaman', $id)->first();

        if (!$peminjaman) {
            return redirect(route('petugas.peminjaman.index'))->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $jumlah = $peminjaman->jumlah ?? $peminjaman->jml ?? $peminjaman->qty ?? 1;
        $alat = Alat::where('id_alat', $peminjaman->id_alat)->first();
        
        if ($alat) {
            if ($alat->stok <= 0) {
                return redirect(route('petugas.peminjaman.index'))->with('error', 'Gagal! Stok alat sudah habis (0 unit).');
            }
            if ($alat->stok < $jumlah) {
                return redirect(route('petugas.peminjaman.index'))->with('error', 'Gagal! Stok alat tidak mencukupi (Sisa stok: ' . $alat->stok . ').');
            }
            $alat->stok = max(0, $alat->stok - $jumlah);
            $alat->save();
        }

        $peminjaman->update([
            'status' => 'Disetujui'
        ]);

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Petugas menyetujui transaksi peminjaman (ID: ' . $id . ').'
        ]);

        return redirect(route('petugas.peminjaman.index'))->with('success', 'Peminjaman alat berhasil disetujui dan stok otomatis berkurang!');
    }

    public function tolakPetugas(Request $request, $id)
    {
        $peminjaman = Peminjaman::where('id_peminjaman', $id)->first();

        if (!$peminjaman) {
            return redirect(route('petugas.peminjaman.index'))->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $statusSekarang = strtolower($peminjaman->status);
        if ($statusSekarang !== 'pending' && $statusSekarang !== 'menunggu') {
            return redirect(route('petugas.peminjaman.index'))->with('error', 'Hanya pengajuan berstatus Pending yang bisa ditolak.');
        }

        $peminjaman->update([
            'status' => 'Ditolak'
        ]);

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Petugas menolak transaksi peminjaman (ID: ' . $id . ').'
        ]);

        return redirect(route('petugas.peminjaman.index'))->with('success', 'Peminjaman alat ditolak.');
    }

    public function setujuiPengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::where('id_peminjaman', $id)->first();

        if (!$peminjaman) {
            return redirect(route('petugas.peminjaman.index'))->with('error', 'Data peminjaman tidak ditemukan.');
        }

        if ($peminjaman->status !== 'Menunggu Pengembalian') {
            return redirect(route('petugas.peminjaman.index'))->with('error', 'Status peminjaman bukan pengajuan pengembalian.');
        }

        $jumlah = $peminjaman->jumlah ?? $peminjaman->jml ?? $peminjaman->qty ?? 1;
        $alat = Alat::where('id_alat', $peminjaman->id_alat)->first();
        
        if ($alat) {
            $alat->stok += $jumlah;
            $alat->save();
        }

        $peminjaman->update([
            'status' => 'Dikembalikan'
        ]);

        // Jika belum ada record pengembalian (misal lewat tombol cepat), buat default. Jika sudah ada (dari form siswa), biarkan inputan asli siswa (kondisi & catatan) tetap utuh!
        if (class_exists('App\Models\Pengembalian')) {
            $pengembalianSiswa = \App\Models\Pengembalian::where('id_peminjaman', $id)->first();

            if (!$pengembalianSiswa) {
                $tglJatuhTempo = $peminjaman->tanggal_kembali ?? $peminjaman->tanggal_selesai ?? date('Y-m-d');
                $tglRencana = new \DateTime($tglJatuhTempo);
                $tglAktual = new \DateTime(date('Y-m-d'));
                
                $tglRencana->setTime(0, 0, 0);
                $tglAktual->setTime(0, 0, 0);

                $selisihHari = 0;
                $denda = 0;
                if ($tglAktual > $tglRencana) {
                    $interval = $tglRencana->diff($tglAktual);
                    $selisihHari = $interval->days;
                    $denda = $selisihHari * 2000;
                }

                \App\Models\Pengembalian::create([
                    'id_peminjaman'        => $peminjaman->id_peminjaman,
                    'tanggal_pengembalian' => date('Y-m-d'),
                    'kondisi_barang'       => 'Baik',
                    'terlambat_hari'       => $selisihHari,
                    'denda'                => $denda,
                    'catatan'              => 'Disetujui oleh petugas'
                ]);
            }
        }

        $currentUser = User::current();
        LogAktifitas::create([
            'id_user'   => $currentUser->id ?? null,
            'aktifitas' => 'Petugas memverifikasi dan menyetujui pengembalian alat (ID: ' . $id . '). Stok alat bertambah.'
        ]);

        return redirect(route('petugas.peminjaman.index'))->with('success', 'Pengajuan pengembalian berhasil diverifikasi, stok dikembalikan, dan masuk ke laporan!');
    }
}
