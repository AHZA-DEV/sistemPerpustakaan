
@extends('layouts.app')

@section('title', 'Tambah Anggota - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Tambah Anggota Baru</h2>
                    <p class="text-muted mb-0">Tambahkan anggota baru ke sistem perpustakaan</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Form Tambah Anggota</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap *</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                               id="nama" name="nama" value="{{ old('nama') }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nisn_nim" class="form-label">NISN/NIM *</label>
                                        <input type="text" class="form-control @error('nisn_nim') is-invalid @enderror" 
                                               id="nisn_nim" name="nisn_nim" value="{{ old('nisn_nim') }}" required>
                                        @error('nisn_nim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password *</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telepon" class="form-label">Telepon *</label>
                                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                               id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status_keanggotaan" class="form-label">Status Keanggotaan *</label>
                                        <select class="form-select @error('status_keanggotaan') is-invalid @enderror" 
                                                id="status_keanggotaan" name="status_keanggotaan" required>
                                            <option value="">Pilih Status</option>
                                            <option value="AKTIF" {{ old('status_keanggotaan') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                                            <option value="NONAKTIF" {{ old('status_keanggotaan') == 'NONAKTIF' ? 'selected' : '' }}>Non-Aktif</option>
                                        </select>
                                        @error('status_keanggotaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat *</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Anggota
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Panduan Pengisian</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    <small>NISN/NIM harus unik dan tidak boleh duplikat</small>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    <small>Email akan digunakan untuk login anggota</small>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    <small>Password minimal 6 karakter</small>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    <small>Status Aktif memungkinkan anggota untuk login</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
