
@extends('layouts.app')

@section('title', 'Profil Saya - User')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Profil Saya</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Beranda</a></li>
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
                        <h4 class="mb-1">{{ Session::get('user_name', 'Anggota') }}</h4>
                        <p class="text-muted mb-0">Anggota Perpustakaan</p>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="mb-1">{{ \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))->count() }}</h5>
                                <small class="text-muted">Total Peminjaman</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-1">{{ \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))->whereNull('tanggal_kembali')->count() }}</h5>
                            <small class="text-muted">Sedang Dipinjam</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member Info Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Keanggotaan</h6>
                </div>
                <div class="card-body">
                    @php
                        $anggota = \App\Models\Anggota::find(Session::get('user_id'));
                    @endphp
                    
                    @if($anggota)
                    <div class="mb-3">
                        <small class="text-muted">ID Anggota</small>
                        <div class="fw-medium">{{ $anggota->anggota_id }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Tanggal Bergabung</small>
                        <div class="fw-medium">{{ $anggota->created_at ? $anggota->created_at->format('d M Y') : '-' }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div><span class="badge bg-success">Aktif</span></div>
                    </div>
                    @else
                    <div class="text-muted">Data anggota tidak ditemukan</div>
                    @endif
                </div>
            </div>

            <!-- Reading Activity Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Aktivitas Membaca</h6>
                </div>
                <div class="card-body">
                    @php
                        $peminjamanSelesai = \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))
                            ->whereNotNull('tanggal_kembali')
                            ->count();
                        $peminjamanTerlambat = \App\Models\Peminjaman::where('anggota_id', Session::get('user_id'))
                            ->whereNull('tanggal_kembali')
                            ->where('tanggal_harus_kembali', '<', now())
                            ->count();
                    @endphp
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Buku Selesai Dibaca</span>
                        <span class="badge bg-success">{{ $peminjamanSelesai }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Terlambat</span>
                        <span class="badge bg-{{ $peminjamanTerlambat > 0 ? 'danger' : 'secondary' }}">{{ $peminjamanTerlambat }}</span>
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
                    <form action="{{ route('user.profile.update') }}" method="POST">
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                           id="telepon" name="telepon" value="{{ old('telepon', $anggota->telepon ?? '') }}">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ?? '') }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3">{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

            <!-- Recent Activity Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    @php
                        $recentLoans = \App\Models\Peminjaman::with('buku')
                            ->where('anggota_id', Session::get('user_id'))
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($recentLoans->count() > 0)
                        @foreach($recentLoans as $loan)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-{{ $loan->tanggal_kembali ? 'success' : 'primary' }} rounded-circle">
                                        <i class="bi bi-book"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $loan->buku->judul ?? 'Buku tidak ditemukan' }}</h6>
                                <p class="text-muted mb-0">
                                    {{ $loan->tanggal_kembali ? 'Dikembalikan' : 'Dipinjam' }} pada {{ $loan->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="badge bg-{{ $loan->tanggal_kembali ? 'success' : 'warning' }}">
                                    {{ $loan->tanggal_kembali ? 'Selesai' : 'Aktif' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-book display-4"></i>
                            <p class="mt-2">Belum ada aktivitas peminjaman</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.avatar-sm {
    height: 2rem;
    width: 2rem;
}

.avatar-title {
    align-items: center;
    background-color: #6c757d;
    color: #fff;
    display: flex;
    font-size: .875rem;
    font-weight: 500;
    height: 100%;
    justify-content: center;
    width: 100%;
}
</style>
@endpush
