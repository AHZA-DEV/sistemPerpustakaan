
@extends('layouts.app')

@section('title', 'Tambah Kategori - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Tambah Kategori Baru</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kelola Kategori</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Form Tambah Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" 
                                   placeholder="Contoh: Teknologi, Fiksi, Sains..." required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan nama kategori yang unik dan mudah dipahami</small>
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="4" 
                                      placeholder="Masukkan deskripsi kategori...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Jelaskan secara singkat tentang kategori ini (opsional)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-lg-8 mx-auto">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="card-title text-info">
                        <i class="bi bi-info-circle me-2"></i>Informasi Penting
                    </h6>
                    <ul class="mb-0 text-muted small">
                        <li>Nama kategori harus unik dan tidak boleh sama dengan kategori yang sudah ada</li>
                        <li>Kategori yang telah dibuat dapat digunakan untuk mengklasifikasikan buku</li>
                        <li>Deskripsi membantu pengguna memahami jenis buku yang termasuk dalam kategori</li>
                        <li>Kategori dapat diedit atau dihapus jika tidak lagi diperlukan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
