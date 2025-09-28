<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthorController extends Controller
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

        $authors = Author::with('bukus')->orderBy('nama_author')->get();
        
        return view('admin.author.index', compact('authors'));
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

        return view('admin.author.create');
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
            'nama_author' => 'required|string|max:255|unique:authors,nama_author',
            'email' => 'nullable|email|max:255|unique:authors,email',
            'biografi' => 'nullable|string',
        ], [
            'nama_author.required' => 'Nama author wajib diisi.',
            'nama_author.unique' => 'Nama author sudah ada.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        Author::create([
            'nama_author' => $request->nama_author,
            'email' => $request->email,
            'biografi' => $request->biografi,
        ]);

        return redirect()->route('admin.author.index')->with('success', 'Author berhasil ditambahkan.');
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

        $author = Author::with('bukus')->findOrFail($id);
        
        return view('admin.author.edit', compact('author'));
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

        $author = Author::findOrFail($id);

        $request->validate([
            'nama_author' => 'required|string|max:255|unique:authors,nama_author,' . $id . ',author_id',
            'email' => 'nullable|email|max:255|unique:authors,email,' . $id . ',author_id',
            'biografi' => 'nullable|string',
        ], [
            'nama_author.required' => 'Nama author wajib diisi.',
            'nama_author.unique' => 'Nama author sudah ada.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $author->update([
            'nama_author' => $request->nama_author,
            'email' => $request->email,
            'biografi' => $request->biografi,
        ]);

        return redirect()->route('admin.author.index')->with('success', 'Author berhasil diperbarui.');
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

        $author = Author::with('bukus')->findOrFail($id);

        // Check if author has related books
        if ($author->bukus->count() > 0) {
            return redirect()->route('admin.author.index')->with('error', 'Tidak dapat menghapus author yang masih digunakan oleh buku.');
        }

        $author->delete();

        return redirect()->route('admin.author.index')->with('success', 'Author berhasil dihapus.');
    }
}
