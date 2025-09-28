@extends('layouts.app')

@section('title', 'Edit Penerbit - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Edit Penerbit</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.penerbit.index') }}">Kelola Penerbit</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Penerbit</li>
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
                        <i class="bi bi-pencil me-2"></i>Form Edit Penerbit
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.penerbit.update', $penerbit->penerbit_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_penerbit" class="form-label">Nama Penerbit <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_penerbit') is-invalid @enderror"
                                id="nama_penerbit" name="nama_penerbit"
                                value="{{ old('nama_penerbit', $penerbit->nama_penerbit) }}"
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
                                    name="email" value="{{ old('email', $penerbit->email) }}"
                                    placeholder="contoh@penerbit.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                                    name="telepon" value="{{ old('telepon', $penerbit->telepon) }}"
                                    placeholder="021-1234567">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                rows="4"
                                placeholder="Masukkan alamat lengkap penerbit...">{{ old('alamat', $penerbit->alamat) }}</textarea>
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
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>Update Penerbit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="card-title text-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>Peringatan
                    </h6>
                    <div class="text-muted small">
                        <p class="mb-2"><strong>Penerbit ini memiliki {{ $penerbit->bukus->count() }} buku terkait.</strong>
                        </p>
                        <ul class="mb-0">
                            <li>Mengubah nama penerbit akan mempengaruhi semua buku yang menggunakan penerbit ini</li>
                            <li>Pastikan informasi kontak tetap valid dan up-to-date</li>
                            <li>Jika ingin menghapus penerbit, pastikan tidak ada buku yang menggunakannya</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection