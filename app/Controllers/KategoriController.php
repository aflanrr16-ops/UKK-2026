<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
$kategori = Kategori::orderBy('id_kategori','desc')->paginate(10);
return view ('kategori.index', compact('kategori'));
    }
}
public function create(request $request)
{
    return view('Kategori.create');
}
public function store(request $request)
{
    $request->validate([
        'namna' => 'required|string|max:255'
    ]);

    Kategori::create([
        'keterangan' => $request->input('nama'),
    ]);

    return redirect{}->route('kategori.index')->with('success','Kategori berhasil ditambahkan');
}
