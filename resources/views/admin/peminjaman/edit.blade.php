
@extends('layouts.app')

@section('title', 'Edit Peminjaman - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Edit Peminjaman</h2>
                    <p class="text-muted mb-0">Edit data peminjaman: {{ $peminjaman->anggota->nama }} - {{ $peminjaman->buku->judul }}</p>
                </div>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Form Edit Peminjaman</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.peminjaman.update', $peminjaman) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="anggota_id" class="form-label">Pilih Anggota *</label>
                                        <select class="form-select @error('anggota_id') is-invalid @enderror" 
                                                id="anggota_id" name="anggota_id" required>
                                            <option value="">Pilih Anggota...</option>
                                            @foreach($anggotas as $anggota)
                                                <option value="{{ $anggota->anggota_id }}" {{ old('anggota_id', $peminjaman->anggota_id) == $anggota->anggota_id ? 'selected' : '' }}>
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
                                                <option value="{{ $buku->buku_id }}" {{ old('buku_id', $peminjaman->buku_id) == $buku->buku_id ? 'selected' : '' }}>
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
                                               value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam->format('Y-m-d')) }}" required>
                                        @error('tanggal_pinjam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_kembali" class="form-label">Tanggal Jatuh Tempo *</label>
                                        <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                               id="tanggal_kembali" name="tanggal_kembali" 
                                               value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali->format('Y-m-d')) }}" required>
                                        @error('tanggal_kembali')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="DIPINJAM" {{ old('status', $peminjaman->status) == 'DIPINJAM' ? 'selected' : '' }}>Dipinjam</option>
                                            <option value="DIKEMBALIKAN" {{ old('status', $peminjaman->status) == 'DIKEMBALIKAN' ? 'selected' : '' }}>Dikembalikan</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_dikembalikan" class="form-label">Tanggal Dikembalikan</label>
                                        <input type="date" class="form-control @error('tanggal_dikembalikan') is-invalid @enderror" 
                                               id="tanggal_dikembalikan" name="tanggal_dikembalikan" 
                                               value="{{ old('tanggal_dikembalikan', $peminjaman->tanggal_dikembalikan ? $peminjaman->tanggal_dikembalikan->format('Y-m-d') : '') }}">
                                        <div class="form-text">Kosongkan jika belum dikembalikan</div>
                                        @error('tanggal_dikembalikan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="denda" class="form-label">Denda (Rp)</label>
                                    <input type="number" class="form-control @error('denda') is-invalid @enderror" 
                                           id="denda" name="denda" min="0" step="1000"
                                           value="{{ old('denda', $peminjaman->denda) }}">
                                    <div class="form-text">Denda keterlambatan pengembalian</div>
                                    @error('denda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Update Peminjaman
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Informasi Peminjaman</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>ID Peminjaman:</strong><br>
                                    <span class="text-muted">{{ $peminjaman->peminjaman_id }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Dibuat:</strong><br>
                                    <span class="text-muted">{{ $peminjaman->created_at->format('d M Y H:i') }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Terakhir Update:</strong><br>
                                    <span class="text-muted">{{ $peminjaman->updated_at->format('d M Y H:i') }}</span>
                                </li>
                                @if($peminjaman->isOverdue() && $peminjaman->status === 'DIPINJAM')
                                    <li class="mb-2">
                                        <strong>Status:</strong><br>
                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Terlambat {{ $peminjaman->getDaysOverdue() }} hari
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Denda yang Dikenakan:</strong><br>
                                        <span class="text-danger fw-bold">
                                            Rp {{ number_format($peminjaman->calculateDenda(), 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    @if($peminjaman->status === 'DIPINJAM')
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Aksi Cepat</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.peminjaman.destroy', $peminjaman) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100" 
                                        onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                    <i class="bi bi-arrow-return-left me-2"></i>Kembalikan Buku
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const tanggalDikembalikan = document.getElementById('tanggal_dikembalikan');
    const dendaInput = document.getElementById('denda');

    statusSelect.addEventListener('change', function() {
        if (this.value === 'DIKEMBALIKAN' && !tanggalDikembalikan.value) {
            tanggalDikembalikan.value = new Date().toISOString().split('T')[0];
        } else if (this.value === 'DIPINJAM') {
            tanggalDikembalikan.value = '';
        }
    });

    tanggalDikembalikan.addEventListener('change', function() {
        if (this.value) {
            statusSelect.value = 'DIKEMBALIKAN';
            
            // Auto calculate fine if overdue
            const returnDate = new Date(this.value);
            const dueDate = new Date(document.getElementById('tanggal_kembali').value);
            
            if (returnDate > dueDate) {
                const diffTime = returnDate - dueDate;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const fine = diffDays * 1000; // Rp 1000 per day
                dendaInput.value = fine;
            }
        }
    });
});
</script>
@endsection
