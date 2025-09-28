<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserBukuController extends Controller
{
    public function index()
    {
        // Check if user is logged in as anggota
        if (!Session::has('user_id') || Session::get('user_type') !== 'anggota') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $bukus = Buku::with(['penerbit', 'authors', 'kategoriModel'])->where('stok', '>', 0)->get();
        $kategoris = Kategori::all();
        
        return view('user.buku.index', compact('bukus', 'kategoris'));
    }

    public function show($id)
    {
        // Check if user is logged in as anggota
        if (!Session::has('user_id') || Session::get('user_type') !== 'anggota') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $buku = Buku::with(['penerbit', 'authors', 'kategoriModel'])->findOrFail($id);
        
        return response()->json([
            'id' => $buku->buku_id,
            'judul' => $buku->judul,
            'isbn' => $buku->isbn,
            'tahun_terbit' => $buku->tahun_terbit,
            'stok' => $buku->stok,
            'kategori' => $buku->kategori,
            'penerbit' => $buku->penerbit->nama_penerbit ?? 'N/A',
            'authors' => $buku->authors->pluck('nama_author')->join(', '),
            'available' => $buku->stok > 0
        ]);
    }

    public function detail($id)
    {
        // Check if user is logged in as anggota
        if (!Session::has('user_id') || Session::get('user_type') !== 'anggota') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $buku = Buku::with(['penerbit', 'authors', 'kategoriModel'])->findOrFail($id);
        
        // Get related books from the same category (excluding current book)
        $relatedBooks = Buku::with(['penerbit', 'authors'])
            ->where('kategori', $buku->kategori)
            ->where('buku_id', '!=', $id)
            ->where('stok', '>', 0)
            ->limit(8)
            ->get();
        
        return view('user.buku.detail', compact('buku', 'relatedBooks'));
    }
}
