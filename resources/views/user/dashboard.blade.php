
@extends('layouts.app')

@section('title', 'Dashboard - Anggota')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="welcome-section">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h2 class="mb-2">Selamat Datang, {{ Session::get('user_name') }}</h2>
                        <p class="text-muted">Dashboard Perpustakaan Digital untuk Anggota. Jelajahi koleksi buku dan kelola peminjaman Anda.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Peminjaman Aktif</h5>
                        <a href="{{ route('user.loans.index') }}" class="text-primary text-decoration-none">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $activePeminjamans = \App\Models\Peminjaman::with(['buku'])
                                           ->where('anggota_id', Session::get('user_id'))
                                           ->where('status', 'DIPINJAM')
                                           ->latest()
                                           ->take(3)
                                           ->get();
                    @endphp
                    
                    <div class="loan-list">
                        @forelse($activePeminjamans as $peminjaman)
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://via.placeholder.com/50x65/007bff/ffffff?text=Book" alt="Book Cover" class="me-3 rounded" style="width: 40px; height: 52px;">
                                <div class="flex-grow-1">
                                    <div class="fw-bold card-title">{{ Str::limit($peminjaman->buku->judul, 20) }}</div>
                                    <small class="text-muted">Jatuh tempo: {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') : 'N/A' }}</small>
                                </div>
                                @if($peminjaman->isOverdue())
                                    <span class="badge bg-danger">Terlambat</span>
                                @elseif(\Carbon\Carbon::parse($peminjaman->tanggal_kembali)->diffInDays(now()) <= 2)
                                    <span class="badge bg-warning">Hampir Jatuh Tempo</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="bi bi-journal-text text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2 mb-0">Belum ada peminjaman aktif</p>
                                <a href="{{ route('user.books.index') }}" class="btn btn-sm btn-primary mt-2">
                                    Pinjam Buku Sekarang
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        @php
            $totalPeminjaman = \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))->count();
            $activePeminjamanCount = \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))->where('status', 'DIPINJAM')->count();
            $returnedCount = \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))->where('status', 'DIKEMBALIKAN')->count();
            $overdueCount = \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))
                          ->where('status', 'DIPINJAM')
                          ->where('tanggal_kembali', '<', now())
                          ->count();
        @endphp
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-journal-arrow-up text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $activePeminjamanCount }}</h4>
                    <p class="text-muted mb-0">Sedang Dipinjam</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-return-left text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $returnedCount }}</h4>
                    <p class="text-muted mb-0">Total Dikembalikan</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $overdueCount }}</h4>
                    <p class="text-muted mb-0">Terlambat</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $totalPeminjaman }}</h4>
                    <p class="text-muted mb-0">Total Peminjaman</p>
                </div>
            </div>
        </div>
    </div>

@endsection
