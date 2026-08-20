<?php

namespace App\Controllers;

use App\Models\User;
use Batara\Controller;
use Batara\Http\Request;
use Batara\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
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
