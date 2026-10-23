<?php

namespace App\Controllers\Core;

use App\Models\Role;
use App\Models\User;
use Sakuci\Controller;
use Sakuci\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('core.admin.users.index', [
            'users' => User::orderBy('id', 'asc')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:3|max:50|alpha_dash|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|exists:roles,name',
        ]);

        User::create([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role'],
        ]);

        return back()->with('success', 'User "' . $data['username'] . '" berhasil ditambahkan.');
    }

    // --- FUNGSI EDIT USER ---
    public function edit($id)
    {
        $userToEdit = User::find($id);
        if (!$userToEdit) {
            return redirect(route('admin.users.index'))->with('error', 'User tidak ditemukan.');
        }

        return view('core.admin.users.index', [
            'users'      => User::orderBy('id', 'asc')->get(),
            'roles'      => Role::orderBy('name')->get(),
            'userToEdit' => $userToEdit, // Dikirim ke view untuk mengisi form edit
        ]);
    }

    // --- FUNGSI UPDATE USER ---
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect(route('admin.users.index'))->with('error', 'User tidak ditemukan.');
        }

        $data = $request->validate([
            'username' => 'required|min:3|max:50|alpha_dash|unique:users,username,' . $id,
            'role'     => 'required|exists:roles,name',
        ]);

        $updateData = [
            'username' => $data['username'],
            'role'     => $data['role'],
        ];

        // Jika password diisi, baru di-update
        if ($request->input('password')) {
            $request->validate(['password' => 'min:6']);
            $updateData['password'] = password_hash($request->input('password'), PASSWORD_DEFAULT);
        }

        $user->update($updateData);

        return redirect(route('admin.users.index'))->with('success', 'User "' . $user->username . '" berhasil diperbarui.');
    }

    // --- FUNGSI HAPUS USER ---
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $username = $user->username;
            $user->delete();
            return back()->with('success', 'User "' . $username . '" berhasil dihapus.');
        }

        return back()->with('error', 'User tidak ditemukan.');
    }
}