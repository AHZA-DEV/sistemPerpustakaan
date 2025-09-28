
@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-section">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="mb-2">Selamat Datang, {{ $adminName ?? 'Admin' }}</h2>
                        <p class="text-muted mb-0">Dashboard Digital Library Management System. Kelola perpustakaan dengan
                            mudah dan efisien.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-calendar3 me-2"></i>Hari ini ({{ date('d M Y') }})
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <!-- Total Anggota -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-blue h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Total Anggota</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Anggota::count() }}</h2>
                    <small class="text-white-50">+15% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Total Buku -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-purple h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Total Buku</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Buku::count() }}</h2>
                    <small class="text-white-50">+8% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Buku Dipinjam -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-indigo h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Sedang Dipinjam</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</h2>
                    <small class="text-white-50">-3% dari minggu lalu</small>
                </div>
            </div>
        </div>

        <!-- Kategori -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-orange h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Total Kategori</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Kategori::count() }}</h2>
                    <small class="text-white-50">{{ \App\Models\Kategori::whereDate('created_at', '>=', now()->subMonth())->count() }} kategori baru</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row mb-4">
        <!-- Total Penerbit -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-teal h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Total Penerbit</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Penerbit::count() }}</h2>
                    <small class="text-white-50">{{ \App\Models\Penerbit::whereDate('created_at', '>=', now()->subMonth())->count() }} penerbit baru</small>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-green h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Peminjaman Hari Ini</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Peminjaman::whereDate('tanggal_pinjam', today())->count() }}</h2>
                    <small class="text-white-50">Peminjaman baru</small>
                </div>
            </div>
        </div>

        <!-- Pengembalian Hari Ini -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-cyan h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Pengembalian Hari Ini</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Peminjaman::whereDate('tanggal_kembali', today())->count() }}</h2>
                    <small class="text-white-50">Buku dikembalikan</small>
                </div>
            </div>
        </div>

        <!-- Keterlambatan -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-red h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Keterlambatan</h6>
                    <h2 class="card-title text-white mb-2">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->where('tanggal_jatuh_tempo', '<', now())->count() }}</h2>
                    <small class="text-white-50">Perlu tindak lanjut</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.buku.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success w-100">
                                <i class="bi bi-person-plus me-2"></i>Tambah Anggota
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.kategori.create') }}" class="btn btn-info w-100">
                                <i class="bi bi-tag-fill me-2"></i>Tambah Kategori
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.penerbit.create') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-building me-2"></i>Tambah Penerbit
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('laporan.index') }}" class="btn btn-warning w-100">
                                <i class="bi bi-graph-up me-2"></i>Lihat Laporan
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-success w-100">
                                <i class="bi bi-journal-arrow-up me-2"></i>Kelola Peminjaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Peminjaman Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Peminjaman::with(['anggota', 'buku'])->latest()->take(5)->get() as $peminjaman)
                                <tr>
                                    <td>{{ $peminjaman->anggota->nama ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->buku->judul ?? 'N/A' }}</td>
                                    <td>{{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $peminjaman->status == 'dipinjam' ? 'primary' : 'success' }}">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data peminjaman</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Buku Terpopuler</h5>
                </div>
                <div class="card-body">
                    @forelse(\App\Models\Buku::withCount('peminjamans')->orderBy('peminjamans_count', 'desc')->take(5)->get() as $index => $buku)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <span class="badge bg-{{ $index == 0 ? 'warning' : 'secondary' }}">{{ $index + 1 }}</span>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $buku->judul }}</h6>
                            <small class="text-muted">{{ $buku->peminjamans_count }} kali dipinjam</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada data buku</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
