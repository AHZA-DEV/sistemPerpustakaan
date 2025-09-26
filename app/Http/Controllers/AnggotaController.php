<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AnggotaController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $anggotas = Anggota::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('anggotas'));
    }

    public function create()
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'nisn_nim' => 'required|string|max:20|unique:anggotas,nisn_nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:anggotas,email',
            'password' => 'required|string|min:6',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
            'status_keanggotaan' => 'required|in:AKTIF,NONAKTIF'
        ]);

        Anggota::create([
            'nisn_nim' => $request->nisn_nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'status_keanggotaan' => $request->status_keanggotaan,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Anggota $user)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(Anggota $user)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, Anggota $user)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'nisn_nim' => 'required|string|max:20|unique:anggotas,nisn_nim,' . $user->anggota_id . ',anggota_id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:anggotas,email,' . $user->anggota_id . ',anggota_id',
            'password' => 'nullable|string|min:6',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
            'status_keanggotaan' => 'required|in:AKTIF,NONAKTIF'
        ]);

        $data = [
            'nisn_nim' => $request->nisn_nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'status_keanggotaan' => $request->status_keanggotaan,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data anggota berhasil diupdate!');
    }

    public function destroy(Anggota $user)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        // Check if user has active loans
        if ($user->peminjamans()->where('status', 'DIPINJAM')->count() > 0) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus anggota yang masih memiliki peminjaman aktif!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Anggota berhasil dihapus!');
    }
}
