<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function dashboard()
    {
        // Cek apakah user sudah login dan tipe user adalah anggota
        if (!Session::has('user_id') || Session::get('user_type') !== 'anggota') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $userName = Session::get('user_name');
        return view('user.dashboard', compact('userName'));
    }
}
