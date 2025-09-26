
@extends('layouts.app')

@section('title', 'Tambah Peminjaman - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Tambah Peminjaman</h2>
                    <p class="text-muted mb-0">Tambah data peminjaman buku baru</p>
                </div>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Form Tambah Peminjaman</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="anggota_id" class="form-label">Pilih Anggota *</label>
                                        <select class="form-select @error('anggota_id') is-invalid @enderror" 
                                                id="anggota_id" name="anggota_id" required>
                                            <option value="">Pilih Anggota...</option>
                                            @foreach($anggotas as $anggota)
                                                <option value="{{ $anggota->anggota_id }}" {{ old('anggota_id') == $anggota->anggota_id ? 'selected' : '' }}>
                                                    {{ $anggota->nama }} ({{ $anggota->nisn_nim }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('anggota_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="buku_id" class="form-label">Pilih Buku *</label>
                                        <select class="form-select @error('buku_id') is-invalid @enderror" 
                                                id="buku_id" name="buku_id" required>
                                            <option value="">Pilih Buku...</option>
                                            @foreach($bukus as $buku)
                                                <option value="{{ $buku->buku_id }}" {{ old('buku_id') == $buku->buku_id ? 'selected' : '' }}>
                                                    {{ $buku->judul }} (Stok: {{ $buku->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('buku_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam *</label>
                                        <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                               id="tanggal_pinjam" name="tanggal_pinjam" 
                                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                                        @error('tanggal_pinjam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_kembali" class="form-label">Tanggal Jatuh Tempo *</label>
                                        <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                               id="tanggal_kembali" name="tanggal_kembali" 
                                               value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required>
                                        @error('tanggal_kembali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Peminjaman
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Informasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">
                                    <i class="bi bi-info-circle me-2"></i>Ketentuan Peminjaman
                                </h6>
                                <ul class="mb-0">
                                    <li>Periode peminjaman default: 7 hari</li>
                                    <li>Denda keterlambatan: Rp 1.000/hari</li>
                                    <li>Anggota harus dalam status AKTIF</li>
                                    <li>Buku harus tersedia (stok > 0)</li>
                                </ul>
                            </div>

                            <div class="mt-3">
                                <h6>Statistik Hari Ini</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between">
                                        <span>Peminjaman Baru:</span>
                                        <strong>{{ \App\Models\Peminjaman::whereDate('created_at', today())->count() }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Pengembalian:</span>
                                        <strong>{{ \App\Models\Peminjaman::whereDate('tanggal_dikembalikan', today())->count() }}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalPinjam = document.getElementById('tanggal_pinjam');
    const tanggalKembali = document.getElementById('tanggal_kembali');

    tanggalPinjam.addEventListener('change', function() {
        const pinjamDate = new Date(this.value);
        const kembaliDate = new Date(pinjamDate);
        kembaliDate.setDate(kembaliDate.getDate() + 7); // Default 7 days
        
        tanggalKembali.value = kembaliDate.toISOString().split('T')[0];
    });
});
</script>
@endsection
