<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $data = Kategori::orderBy('id_kategori', 'desc')
        ->paginate(10);
        return view('kategori.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama_kategori' => $request->input('nama_kategori'),
            'keterangan' => $request->input('keterangan'),
            'kode_kategori' => $request->input('kode_kategori'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Request $request, $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return view('kategori.edit', compact('kategori'));

    }

    public function update(Request $request, $id_kategori)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->update([
            'keterangan' => $request->input('keterangan'),
            'nama_kategori' => $request->input('nama_kategori'),
            'kode_kategori' => $request->input('kode_kategori'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->destroy();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

}