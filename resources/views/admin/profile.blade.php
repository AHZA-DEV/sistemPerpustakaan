
@extends('layouts.app')

@section('title', 'Profil Admin - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Profil Admin</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="avatar-placeholder mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="mb-1">{{ Session::get('user_name', 'Admin') }}</h4>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="mb-1">{{ \App\Models\Buku::count() }}</h5>
                                <small class="text-muted">Total Buku</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-1">{{ \App\Models\Anggota::count() }}</h5>
                            <small class="text-muted">Total Anggota</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Statistik Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Peminjaman Aktif</span>
                        <span class="badge bg-primary">{{ \App\Models\Peminjaman::where('tanggal_kembali', null)->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Kategori</span>
                        <span class="badge bg-success">{{ \App\Models\Kategori::count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Penerbit</span>
                        <span class="badge bg-info">{{ \App\Models\Penerbit::count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Edit Profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ old('nama', Session::get('user_name')) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', Session::get('user_email')) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Ubah Password</h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" name="new_password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" 
                                           id="new_password_confirmation" name="new_password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" onclick="history.back()">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
