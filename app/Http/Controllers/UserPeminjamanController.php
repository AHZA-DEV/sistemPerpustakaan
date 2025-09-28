<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class UserPeminjamanController extends Controller
{
    public function index()
    {
        // Check if user is logged in as anggota
        if (!Session::has('user_id') || Session::get('user_type') !== 'anggota') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $anggotaId = Session::get('user_id');
        
        $peminjamans = Peminjaman::with(['buku.authors', 'buku.penerbit'])
                                ->where('anggota_id', $anggotaId)
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        $activePeminjamans = $peminjamans->where('status', 'DIPINJAM');
        $historyPeminjamans = $peminjamans->where('status', 'DIKEMBALIKAN');
        $overduePeminjamans = $activePeminjamans->filter(function($p) {
            return $p->isOverdue();
        });
        
        return view('user.peminjaman.index', compact('peminjamans', 'activePeminjamans', 'historyPeminjamans', 'overduePeminjamans'));
    }

    public function store(Request $request)
    {
        // Check if user is logged in as anggota
        if (!Session::has('user_id') || Session::get('user_type') !== 'anggota') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai anggota terlebih dahulu.');
        }

        $request->validate([
            'buku_id' => 'required|exists:bukus,buku_id',
        ]);

        $anggotaId = Session::get('user_id');
        
        // Check if book is available
        $buku = Buku::find($request->buku_id);
        if ($buku->stok <= 0) {
            return response()->json(['success' => false, 'message' => 'Buku tidak tersedia untuk dipinjam!']);
        }

        // Check if user already borrowed this book
        $existingLoan = Peminjaman::where('anggota_id', $anggotaId)
                                 ->where('buku_id', $request->buku_id)
                                 ->where('status', 'DIPINJAM')
                                 ->first();
        
        if ($existingLoan) {
            return response()->json(['success' => false, 'message' => 'Anda sudah meminjam buku ini!']);
        }

        // Create peminjaman
        $peminjaman = Peminjaman::create([
            'anggota_id' => $anggotaId,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays(7),
            'status' => 'DIPINJAM',
            'denda' => 0,
        ]);

        // Update book stock
        $buku->decrement('stok');

        return response()->json(['success' => true, 'message' => 'Permintaan peminjaman berhasil disubmit! Silakan kunjungi petugas perpustakaan untuk proses lebih lanjut.']);
    }
}
