<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    // Method khusus peminjam untuk melihat daftar alat
    public function daftarAlatPeminjam(Request $request)
    {
        $query = Alat::query();

        // Fitur Cari Alat berdasarkan nama atau kode
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where('nama_alat', 'LIKE', "%{$search}%")
                  ->orWhere('kode_alat', 'LIKE', "%{$search}%");
        }

        $alats = $query->orderBy('id_alat', 'desc')->get();

        // Ambil data kategori untuk relasi tampilan
        $kategoriList = Kategori::all();
        $kategoriMap = [];
        foreach ($kategoriList as $k) {
            $idK = $k->id_kategori ?? $k->id;
            $kategoriMap[$idK] = $k->nama_kategori ?? $k->kategori ?? 'Umum';
        }

        return view('peminjam.daftar_alat', compact('alats', 'kategoriMap'));
    }

    public function index(Request $request)
    {
        $datal = Alat::orderBy('id_alat', 'desc')->paginate(4);
        $kategori = Kategori::all();
        return view('alat.index', compact('datal', 'kategori'));
    }

    public function create(Request $request)
    {
        $kategori = Kategori::all();
        return view('alat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $datal = $request->validate([
            'nama_alat' => 'required|min:3|max:100',
            'kode_alat' => 'required|min:3|max:100',
            'id_kategori' => 'required',
        ]);
        Alat::create($datal);
        return redirect(route('alat.index'))->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Request $request, $id_alat)
    {
        $datal = Alat::findOrFail($id_alat);
        $kategori = Kategori::all();
        return view('alat.edit', compact('datal', 'kategori'));
    }

    public function update(Request $request, $id_alat)
    {
        $datal = $request->all();

        $alat = Alat::findOrFail($id_alat);
        $alat->update($datal);
        return redirect(route('alat.index'))->with('success', 'Alat berhasil diubah');
    }

    public function delete(Request $request, $id_alat)
    {
        $alat = Alat::findOrFail($id_alat);
        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}