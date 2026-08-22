<?php

namespace App\Controllers\Core;

use App\Models\User;
use Sakuci\Controller;
use Sakuci\Http\Request;
use Sakuci\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('core.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::firstWhere('username', $data['username']);

        if (! $user || ! password_verify($data['password'], $user->password)) {
            return back()
                ->withErrors(['username' => 'Username atau password salah.'])
                ->withInput();
        }

        Session::put('user_id', $user->id);

        return redirect(match ($user->role) {
            'admin' => '/admin',
            'staff' => '/staff',
            default => '/dashboard',
        })->with('success', 'Selamat datang, ' . $user->username . '.');
    }

    public function logout()
    {
        Session::forget('user_id');

        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}

