@extends('layouts.app')

@section('title', 'Tambah Penerbit - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Tambah Penerbit</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.penerbit.index') }}">Kelola Penerbit</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Penerbit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-building me-2"></i>Form Tambah Penerbit
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.penerbit.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_penerbit" class="form-label">Nama Penerbit <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_penerbit') is-invalid @enderror"
                                id="nama_penerbit" name="nama_penerbit" value="{{ old('nama_penerbit') }}"
                                placeholder="Contoh: Gramedia, Erlangga, Mizan..." required>
                            @error('nama_penerbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan nama penerbit yang unik dan mudah dikenali</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="contoh@penerbit.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                                    name="telepon" value="{{ old('telepon') }}" placeholder="021-1234567">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                rows="4" placeholder="Masukkan alamat lengkap penerbit...">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Alamat lengkap kantor atau tempat usaha penerbit
                                (opsional)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.penerbit.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Simpan Penerbit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="card-title text-info">
                        <i class="bi bi-info-circle me-2"></i>Informasi Penting
                    </h6>
                    <div class="text-muted small">
                        <ul class="mb-0">
                            <li>Nama penerbit harus unik dan tidak boleh sama dengan yang sudah ada</li>
                            <li>Email dan telepon akan memudahkan komunikasi dengan penerbit</li>
                            <li>Data penerbit dapat digunakan saat menambahkan buku baru</li>
                            <li>Penerbit yang sudah memiliki buku tidak dapat dihapus</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection