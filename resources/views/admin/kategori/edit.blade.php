
@extends('layouts.app')

@section('title', 'Edit Kategori - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Edit Kategori</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kelola Kategori</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
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
                        <i class="bi bi-pencil me-2"></i>Form Edit Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kategori.update', $kategori->kategori_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   id="nama_kategori" name="nama_kategori" 
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
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
                                      placeholder="Masukkan deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Jelaskan secara singkat tentang kategori ini (opsional)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>Update Kategori
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
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="card-title text-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>Peringatan
                    </h6>
                    <div class="text-muted small">
                        <p class="mb-2"><strong>Kategori ini memiliki {{ $kategori->bukus->count() }} buku terkait.</strong></p>
                        <ul class="mb-0">
                            <li>Mengubah nama kategori akan mempengaruhi semua buku yang menggunakan kategori ini</li>
                            <li>Pastikan nama kategori tetap mudah dipahami dan relevan</li>
                            <li>Jika ingin menghapus kategori, pastikan tidak ada buku yang menggunakannya</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
