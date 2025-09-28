
@extends('layouts.app')

@section('title', 'Tambah Author - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Tambah Author Baru</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.author.index') }}">Kelola Author</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Author</li>
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
                        <i class="bi bi-plus-circle me-2"></i>Form Tambah Author
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.author.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nama_author" class="form-label">Nama Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_author') is-invalid @enderror" 
                                   id="nama_author" name="nama_author" value="{{ old('nama_author') }}" 
                                   placeholder="Contoh: Andrea Hirata, Tere Liye, Pramoedya..." required>
                            @error('nama_author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan nama lengkap author</small>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Email author untuk kontak (opsional)</small>
                        </div>

                        <div class="mb-4">
                            <label for="biografi" class="form-label">Biografi</label>
                            <textarea class="form-control @error('biografi') is-invalid @enderror" 
                                      id="biografi" name="biografi" rows="5" 
                                      placeholder="Masukkan biografi singkat author...">{{ old('biografi') }}</textarea>
                            @error('biografi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Riwayat hidup atau pencapaian author (opsional)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.author.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Simpan Author
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
                        <li>Nama author harus unik dan tidak boleh sama dengan author yang sudah ada</li>
                        <li>Author yang telah dibuat dapat digunakan untuk menulis buku</li>
                        <li>Email membantu untuk komunikasi dengan author jika diperlukan</li>
                        <li>Biografi membantu pembaca mengenal author lebih baik</li>
                        <li>Author dapat diedit atau dihapus jika tidak lagi diperlukan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
