<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if user is admin
        if (Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $penerbits = Penerbit::with('bukus')->orderBy('nama_penerbit')->get();
        
        return view('admin.penerbit.index', compact('penerbits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user is admin
        if (Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        return view('admin.penerbit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if (Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $request->validate([
            'nama_penerbit' => 'required|string|max:255|unique:penerbits,nama_penerbit',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ], [
            'nama_penerbit.required' => 'Nama penerbit wajib diisi.',
            'nama_penerbit.unique' => 'Nama penerbit sudah ada.',
            'email.email' => 'Format email tidak valid.',
        ]);

        Penerbit::create([
            'nama_penerbit' => $request->nama_penerbit,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.penerbit.index')->with('success', 'Penerbit berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Check if user is admin
        if (Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $penerbit = Penerbit::with('bukus')->findOrFail($id);
        
        return view('admin.penerbit.edit', compact('penerbit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Check if user is admin
        if (Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $penerbit = Penerbit::findOrFail($id);

        $request->validate([
            'nama_penerbit' => 'required|string|max:255|unique:penerbits,nama_penerbit,' . $id . ',penerbit_id',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ], [
            'nama_penerbit.required' => 'Nama penerbit wajib diisi.',
            'nama_penerbit.unique' => 'Nama penerbit sudah ada.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $penerbit->update([
            'nama_penerbit' => $request->nama_penerbit,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.penerbit.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if user is admin
        if (Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }

        $penerbit = Penerbit::with('bukus')->findOrFail($id);

        // Check if penerbit has related books
        if ($penerbit->bukus->count() > 0) {
            return redirect()->route('admin.penerbit.index')->with('error', 'Tidak dapat menghapus penerbit yang masih digunakan oleh buku.');
        }

        $penerbit->delete();

        return redirect()->route('admin.penerbit.index')->with('success', 'Penerbit berhasil dihapus.');
    }
}
