<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Anggota;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Coba login sebagai admin terlebih dahulu
        $admin = Admin::where('email', $email)->first();
        if ($admin && Hash::check($password, $admin->password)) {
            // Regenerate session untuk keamanan
            Session::regenerate();
            
            // Login berhasil sebagai admin
            Session::put('user_id', $admin->admin_id);
            Session::put('user_type', 'admin');
            Session::put('user_name', $admin->nama);
            Session::put('user_email', $admin->email);
            
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil! Selamat datang Admin ' . $admin->nama);
        }

        // Jika bukan admin, coba login sebagai anggota
        $anggota = Anggota::where('email', $email)->first();
        if ($anggota && Hash::check($password, $anggota->password)) {
            // Cek status keanggotaan
            if (!$anggota->isActive()) {
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'
                ])->withInput();
            }

            // Regenerate session untuk keamanan
            Session::regenerate();
            
            // Login berhasil sebagai anggota
            Session::put('user_id', $anggota->anggota_id);
            Session::put('user_type', 'anggota');
            Session::put('user_name', $anggota->nama);
            Session::put('user_email', $anggota->email);
            
            return redirect()->route('user.dashboard')->with('success', 'Login berhasil! Selamat datang ' . $anggota->nama);
        }

        // Login gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.'
        ])->withInput();
    }

    public function logout()
    {
        Session::invalidate();
        Session::regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
