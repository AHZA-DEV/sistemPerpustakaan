<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $peminjamans = Peminjaman::with(['anggota', 'buku'])
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $anggotas = Anggota::where('status_keanggotaan', 'AKTIF')->get();
        $bukus = Buku::where('stok', '>', 0)->get();
        
        return view('admin.peminjaman.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'anggota_id' => 'required|exists:anggotas,anggota_id',
            'buku_id' => 'required|exists:bukus,buku_id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        // Check if book is available
        $buku = Buku::find($request->buku_id);
        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam!');
        }

        // Check if member is active
        $anggota = Anggota::find($request->anggota_id);
        if ($anggota->status_keanggotaan !== 'AKTIF') {
            return redirect()->back()->with('error', 'Anggota tidak aktif!');
        }

        // Create peminjaman
        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'DIPINJAM',
            'denda' => 0,
        ]);

        // Update book stock
        $buku->decrement('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function show(Peminjaman $peminjaman)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $peminjaman->load(['anggota', 'buku']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $anggotas = Anggota::where('status_keanggotaan', 'AKTIF')->get();
        $bukus = Buku::all();
        
        return view('admin.peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'anggota_id' => 'required|exists:anggotas,anggota_id',
            'buku_id' => 'required|exists:bukus,buku_id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'tanggal_dikembalikan' => 'nullable|date',
            'status' => 'required|in:DIPINJAM,DIKEMBALIKAN',
            'denda' => 'nullable|numeric|min:0',
        ]);

        $oldBukuId = $peminjaman->buku_id;
        $oldStatus = $peminjaman->status;

        // Update peminjaman
        $data = [
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
            'denda' => $request->denda ?? 0,
        ];

        if ($request->filled('tanggal_dikembalikan')) {
            $data['tanggal_dikembalikan'] = $request->tanggal_dikembalikan;
        }

        $peminjaman->update($data);

        // Update book stock if status changed
        if ($oldStatus === 'DIPINJAM' && $request->status === 'DIKEMBALIKAN') {
            // Book returned, increase stock
            $buku = Buku::find($request->buku_id);
            $buku->increment('stok');
        } elseif ($oldStatus === 'DIKEMBALIKAN' && $request->status === 'DIPINJAM') {
            // Book borrowed again, decrease stock
            $buku = Buku::find($request->buku_id);
            $buku->decrement('stok');
        }

        // Handle book change
        if ($oldBukuId !== $request->buku_id) {
            if ($oldStatus === 'DIPINJAM') {
                // Return old book stock
                $oldBuku = Buku::find($oldBukuId);
                $oldBuku->increment('stok');
            }
            
            if ($request->status === 'DIPINJAM') {
                // Decrease new book stock
                $newBuku = Buku::find($request->buku_id);
                $newBuku->decrement('stok');
            }
        }

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil diupdate!');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        // If book is still borrowed, return the stock
        if ($peminjaman->status === 'DIPINJAM') {
            $buku = Buku::find($peminjaman->buku_id);
            $buku->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }

    public function returnBook(Peminjaman $peminjaman)
    {
        // Check if user is admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        if ($peminjaman->status !== 'DIPINJAM') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan!');
        }

        // Calculate fine if overdue
        $denda = 0;
        if (Carbon::now()->isAfter($peminjaman->tanggal_kembali)) {
            $daysOverdue = Carbon::now()->diffInDays($peminjaman->tanggal_kembali);
            $denda = $daysOverdue * 1000; // Rp 1000 per day
        }

        $peminjaman->update([
            'status' => 'DIKEMBALIKAN',
            'tanggal_dikembalikan' => Carbon::now(),
            'denda' => $denda,
        ]);

        // Increase book stock
        $buku = Buku::find($peminjaman->buku_id);
        $buku->increment('stok');

        return redirect()->route('admin.peminjaman.index')->with('success', 'Buku berhasil dikembalikan!');
    }
}
