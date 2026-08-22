<?php

namespace App\Controllers;

use App\Models\Role;
use Sakuci\Controller;
use Sakuci\Http\Request;

/** Halaman admin untuk menambah role baru (admin/staff/user/dst). */
class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|alpha_dash|max:50',
        ]);

        $name = strtolower($data['name']);

        if (Role::firstWhere('name', $name)) {
            return back()->withErrors(['name' => 'Role "' . $name . '" sudah ada.'])->withInput();
        }

        Role::create(['name' => $name]);

        return back()->with('success', 'Role "' . $name . '" berhasil ditambahkan.');
    }
}

