<?php

namespace App\Controllers;

use App\Models\User;
use Sakuci\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['user' => User::current()]);
    }

    public function admin()
    {
        return view('admin.dashboard', ['user' => User::current()]);
    }

    public function staff()
    {
        return view('staff.dashboard', ['user' => User::current()]);
    }

    public function user()
    {
        return view('user.dashboard', ['user' => User::current()]);
    }
}

