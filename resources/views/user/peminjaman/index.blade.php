
@extends('layouts.app')

@section('title', 'Peminjaman Saya - User Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Peminjaman Saya</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Peminjaman Saya</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('user.buku.index') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Pinjam Buku Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-journal-arrow-up text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $activePeminjamans->count() }}</h4>
                    <p class="text-muted mb-0">Sedang Dipinjam</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-return-left text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $historyPeminjamans->count() }}</h4>
                    <p class="text-muted mb-0">Total Dikembalikan</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $activePeminjamans->filter(function($p) { return \Carbon\Carbon::parse($p->tanggal_kembali)->diffInDays(now()) <= 2 && !$p->isOverdue(); })->count() }}</h4>
                    <p class="text-muted mb-0">Hampir Jatuh Tempo</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $overduePeminjamans->count() }}</h4>
                    <p class="text-muted mb-0">Terlambat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="loanTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                                <i class="bi bi-journal-arrow-up me-2"></i>Sedang Dipinjam ({{ $activePeminjamans->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                                <i class="bi bi-clock-history me-2"></i>Riwayat ({{ $historyPeminjamans->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="overdue-tab" data-bs-toggle="tab" data-bs-target="#overdue" type="button" role="tab">
                                <i class="bi bi-exclamation-triangle me-2"></i>Terlambat ({{ $overduePeminjamans->count() }})
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="loanTabsContent">
                <!-- Active Loans Tab -->
                <div class="tab-pane fade show active" id="active" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Peminjaman Aktif</h5>
                        </div>
                        <div class="card-body">
                            @if($activePeminjamans->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Buku</th>
                                                <th scope="col">Tanggal Pinjam</th>
                                                <th scope="col">Jatuh Tempo</th>
                                                <th scope="col">Sisa Hari</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Denda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activePeminjamans as $peminjaman)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://via.placeholder.com/60x80/{{ collect(['007bff', '28a745', 'dc3545', '6366f1', 'f59e0b'])->random() }}/ffffff?text=Book" 
                                                                 alt="Book Cover" class="me-3 rounded" style="width: 50px; height: 65px;">
                                                            <div>
                                                                <div class="fw-bold">{{ $peminjaman->buku->judul ?? 'N/A' }}</div>
                                                                <small class="text-muted">{{ $peminjaman->buku->authors->pluck('nama_author')->join(', ') ?? 'N/A' }}</small>
                                                                <br>
                                                                <small class="text-muted">BK{{ str_pad($peminjaman->buku_id, 3, '0', STR_PAD_LEFT) }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</td>
                                                    <td>
                                                        @php
                                                            $dueDate = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
                                                            $today = \Carbon\Carbon::now();
                                                            $diffInDays = $today->diffInDays($dueDate, false);
                                                        @endphp
                                                        
                                                        @if($diffInDays < 0)
                                                            <span class="badge bg-danger">{{ abs($diffInDays) }} hari terlambat</span>
                                                        @elseif($diffInDays <= 2)
                                                            <span class="badge bg-warning">{{ $diffInDays }} hari lagi</span>
                                                        @else
                                                            <span class="badge bg-success">{{ $diffInDays }} hari lagi</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($peminjaman->isOverdue())
                                                            <span class="badge bg-danger">Terlambat</span>
                                                        @elseif($diffInDays <= 2)
                                                            <span class="badge bg-warning">Hampir Jatuh Tempo</span>
                                                        @else
                                                            <span class="badge bg-primary">Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($peminjaman->denda > 0)
                                                            <span class="text-danger fw-bold">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-journal-text text-muted" style="font-size: 4rem;"></i>
                                    <h4 class="mt-3">Tidak Ada Peminjaman Aktif</h4>
                                    <p class="text-muted">Anda belum meminjam buku apapun saat ini.</p>
                                    <a href="{{ route('user.buku.index') }}" class="btn btn-primary">
                                        <i class="bi bi-search me-2"></i>Jelajahi Buku
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- History Tab -->
                <div class="tab-pane fade" id="history" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Riwayat Peminjaman</h5>
                                <div class="d-flex gap-2">
                                    <select class="form-select form-select-sm" style="width: auto;" id="monthFilter">
                                        <option value="">Semua Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ date('Y') }}-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                {{ \Carbon\Carbon::create(date('Y'), $i, 1)->format('F Y') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($historyPeminjamans->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Buku</th>
                                                <th scope="col">Tanggal Pinjam</th>
                                                <th scope="col">Tanggal Kembali</th>
                                                <th scope="col">Durasi</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Denda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($historyPeminjamans as $peminjaman)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://via.placeholder.com/60x80/{{ collect(['007bff', '28a745', 'dc3545', '6366f1', 'f59e0b'])->random() }}/ffffff?text=Book" 
                                                                 alt="Book Cover" class="me-3 rounded" style="width: 50px; height: 65px;">
                                                            <div>
                                                                <div class="fw-bold">{{ $peminjaman->buku->judul ?? 'N/A' }}</div>
                                                                <small class="text-muted">{{ $peminjaman->buku->authors->pluck('nama_author')->join(', ') ?? 'N/A' }}</small>
                                                                <br>
                                                                <small class="text-muted">BK{{ str_pad($peminjaman->buku_id, 3, '0', STR_PAD_LEFT) }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                                                    <td>{{ $peminjaman->tanggal_dikembalikan ? \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d M Y') : 'N/A' }}</td>
                                                    <td>
                                                        @if($peminjaman->tanggal_dikembalikan)
                                                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)) }} hari
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td><span class="badge bg-success">Dikembalikan</span></td>
                                                    <td>
                                                        @if($peminjaman->denda > 0)
                                                            <span class="text-danger fw-bold">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-clock-history text-muted" style="font-size: 4rem;"></i>
                                    <h4 class="mt-3">Belum Ada Riwayat</h4>
                                    <p class="text-muted">Anda belum pernah meminjam buku sebelumnya.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Overdue Tab -->
                <div class="tab-pane fade" id="overdue" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Peminjaman Terlambat</h5>
                        </div>
                        <div class="card-body">
                            @if($overduePeminjamans->count() > 0)
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Perhatian!
                                    </h6>
                                    <p class="mb-0">Anda memiliki {{ $overduePeminjamans->count() }} peminjaman yang terlambat. Segera kembalikan buku untuk menghindari denda tambahan.</p>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Buku</th>
                                                <th scope="col">Tanggal Pinjam</th>
                                                <th scope="col">Jatuh Tempo</th>
                                                <th scope="col">Hari Terlambat</th>
                                                <th scope="col">Denda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($overduePeminjamans as $peminjaman)
                                                <tr class="table-danger">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://via.placeholder.com/60x80/dc3545/ffffff?text=Book" 
                                                                 alt="Book Cover" class="me-3 rounded" style="width: 50px; height: 65px;">
                                                            <div>
                                                                <div class="fw-bold">{{ $peminjaman->buku->judul ?? 'N/A' }}</div>
                                                                <small class="text-muted">{{ $peminjaman->buku->authors->pluck('nama_author')->join(', ') ?? 'N/A' }}</small>
                                                                <br>
                                                                <small class="text-muted">BK{{ str_pad($peminjaman->buku_id, 3, '0', STR_PAD_LEFT) }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-danger">{{ $peminjaman->getDaysOverdue() }} hari</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger fw-bold">Rp {{ number_format($peminjaman->calculateDenda(), 0, ',', '.') }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                                    <h4 class="mt-3">Tidak Ada Peminjaman Terlambat</h4>
                                    <p class="text-muted">Selamat! Anda tidak memiliki peminjaman yang terlambat.</p>
                                    <a href="{{ route('user.buku.index') }}" class="btn btn-primary">
                                        <i class="bi bi-search me-2"></i>Jelajahi Buku Lainnya
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Filter by month
    document.getElementById('monthFilter')?.addEventListener('change', function() {
        const selectedMonth = this.value;
        const rows = document.querySelectorAll('#history tbody tr');
        
        rows.forEach(row => {
            if (!selectedMonth) {
                row.style.display = '';
                return;
            }
            
            const dateCell = row.cells[1].textContent;
            const rowDate = new Date(dateCell);
            const rowMonth = rowDate.getFullYear() + '-' + String(rowDate.getMonth() + 1).padStart(2, '0');
            
            row.style.display = rowMonth === selectedMonth ? '' : 'none';
        });
    });
</script>
@endpush
