
@extends('layouts.app')

@section('title', 'Kelola Peminjaman - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Kelola Peminjaman</h2>
                    <p class="text-muted mb-0">Kelola data peminjaman buku di perpustakaan</p>
                </div>
                <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Peminjaman
                </a>
            </div>

            <!-- Filter and Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari peminjaman...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Semua Status</option>
                                <option value="DIPINJAM">Dipinjam</option>
                                <option value="DIKEMBALIKAN">Dikembalikan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFromFilter" placeholder="Dari Tanggal">
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateToFilter" placeholder="Sampai Tanggal">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loans Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-journal-arrow-up me-2"></i>Data Peminjaman
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Anggota</th>
                                    <th scope="col">Buku</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Tanggal Kembali</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamans as $index => $peminjaman)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div>
                                            <strong class="text-primary">{{ $peminjaman->anggota->nama }}</strong><br>
                                            <small class="text-muted">{{ $peminjaman->anggota->nisn_nim }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $peminjaman->buku->judul }}</strong><br>
                                            <small class="text-muted">{{ $peminjaman->buku->isbn }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $peminjaman->tanggal_pinjam->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $peminjaman->isOverdue() ? 'bg-danger' : 'bg-warning' }}">
                                            {{ $peminjaman->tanggal_kembali->format('d M Y') }}
                                        </span>
                                        @if($peminjaman->isOverdue() && $peminjaman->status === 'DIPINJAM')
                                            <br><small class="text-danger">Terlambat {{ $peminjaman->getDaysOverdue() }} hari</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($peminjaman->status === 'DIPINJAM')
                                            <span class="badge bg-warning">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                            @if($peminjaman->tanggal_dikembalikan)
                                                <br><small class="text-muted">{{ $peminjaman->tanggal_dikembalikan->format('d M Y') }}</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}" 
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if($peminjaman->status === 'DIPINJAM')
                                                <form action="{{ route('admin.peminjaman.destroy', $peminjaman) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-success" 
                                                            title="Kembalikan Buku"
                                                            onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                                                        <i class="bi bi-arrow-return-left"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.peminjaman.destroy', $peminjaman) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                            <p class="mt-2">Belum ada data peminjaman</p>
                                            <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">
                                                <i class="bi bi-plus-circle me-2"></i>Tambah Peminjaman Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFromFilter = document.getElementById('dateFromFilter');
    const dateToFilter = document.getElementById('dateToFilter');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const dateFrom = dateFromFilter.value;
        const dateTo = dateToFilter.value;

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const statusCell = row.cells[5];
            const statusText = statusCell ? statusCell.textContent.trim() : '';
            
            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = !statusValue || statusText.includes(statusValue);
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    dateFromFilter.addEventListener('change', filterTable);
    dateToFilter.addEventListener('change', filterTable);
});
</script>
@endsection
