@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-section">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="mb-2">Selamat Datang, Admin</h2>
                        <p class="text-muted mb-0">Dashboard Digital Library Management System. Kelola perpustakaan dengan
                            mudah dan efisien.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-calendar3 me-2"></i>Hari ini (${new Date().toLocaleDateString('id-ID')})
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
                    <h2 class="card-title text-white mb-2">1,247</h2>
                    <small class="text-white-50">+15% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Total Buku -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-purple h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Total Buku</h6>
                    <h2 class="card-title text-white mb-2">5,634</h2>
                    <small class="text-white-50">+8% dari bulan lalu</small>
                </div>
            </div>
        </div>

        <!-- Buku Dipinjam -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-indigo h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Sedang Dipinjam</h6>
                    <h2 class="card-title text-white mb-2">432</h2>
                    <small class="text-white-50">-3% dari minggu lalu</small>
                </div>
            </div>
        </div>

        <!-- Kategori -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-orange h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-white-50">Total Kategori</h6>
                    <h2 class="card-title text-white mb-2">28</h2>
                    <small class="text-white-50">2 kategori baru</small>
                </div>
            </div>
        </div>
    </div>
@endsection