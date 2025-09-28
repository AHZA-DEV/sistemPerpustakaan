
@extends('layouts.app')

@section('title', 'Edit Author - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Edit Author</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.author.index') }}">Kelola Author</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Author</li>
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
                        <i class="bi bi-pencil me-2"></i>Form Edit Author
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.author.update', $author->author_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nama_author" class="form-label">Nama Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_author') is-invalid @enderror" 
                                   id="nama_author" name="nama_author" 
                                   value="{{ old('nama_author', $author->nama_author) }}" 
                                   placeholder="Contoh: Andrea Hirata, Tere Liye, Pramoedya..." required>
                            @error('nama_author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan nama lengkap author</small>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" 
                                   value="{{ old('email', $author->email) }}" 
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
                                      placeholder="Masukkan biografi singkat author...">{{ old('biografi', $author->biografi) }}</textarea>
                            @error('biografi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Riwayat hidup atau pencapaian author (opsional)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.author.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>Update Author
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
                        <p class="mb-2"><strong>Author ini memiliki {{ $author->bukus->count() }} buku terkait.</strong></p>
                        <ul class="mb-0">
                            <li>Mengubah nama author akan mempengaruhi semua buku yang ditulis oleh author ini</li>
                            <li>Pastikan informasi kontak tetap valid dan up-to-date</li>
                            <li>Jika ingin menghapus author, pastikan tidak ada buku yang menggunakannya</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
