<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BukuController extends Controller
{
    public function index()
    {
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $bukus = Buku::with(['penerbit', 'authors', 'kategoriModel'])->paginate(10);
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $kategoris = Kategori::all();
        $penerbits = Penerbit::all();
        $authors = Author::all();
        return view('admin.buku.create', compact('kategoris', 'penerbits', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isbn' => 'required|string|unique:bukus,isbn',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'penerbit_id' => 'required|exists:penerbits,penerbit_id',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,author_id'
        ]);

        $buku = Buku::create($request->all());
        $buku->authors()->attach($request->authors);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $buku->load(['penerbit', 'authors', 'kategoriModel']);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $kategoris = Kategori::all();
        $penerbits = Penerbit::all();
        $authors = Author::all();
        $buku->load('authors');
        return view('admin.buku.edit', compact('buku', 'kategoris', 'penerbits', 'authors'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isbn' => 'required|string|unique:bukus,isbn,' . $buku->buku_id . ',buku_id',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'penerbit_id' => 'required|exists:penerbits,penerbit_id',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,author_id'
        ]);

        $buku->update($request->all());
        $buku->authors()->sync($request->authors);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->authors()->detach();
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
