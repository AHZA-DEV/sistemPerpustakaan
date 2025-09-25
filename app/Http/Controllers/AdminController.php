<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Cek apakah user sudah login dan tipe user adalah admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $adminName = Session::get('user_name');
        return view('admin.dashboard', compact('adminName'));
    }
}
