<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class alatController extends Controller
{
    public function index(Request $request)
    {
        $datal = alat::orderBy('id_alat', 'desc')->paginate(4);
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
            'kode_alat' => 'required|varchar|min:3|max:100',
            'id_kategori' => 'required',
        ]);
        alat::create($datal);
        return redirect(route('alat.index'))->with('success', 'Alat berhasil ditambahkan.');
    }

   public function edit(Request $request, $id_alat)
{
    $datal = alat::findOrFail($id_alat);
    $kategori = Kategori::all();
    return view('alat.edit', compact('datal', 'kategori'));
}

    public function update (Request $request, $id_alat)
    {
        $datal = $request->all();

        $alat = alat::FindOrfail($id_alat);
        $alat->update($datal);
        return redirect(route('alat.index'))->with('success', 'alat berhasil diubah');
    }
   public function delete(Request $request, $id_alat)
    {
        $alat = alat::findOrFail($id_alat);
        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'alat berhasil dihapus.');
    }
}