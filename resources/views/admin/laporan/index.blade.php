
@extends('layouts.app')

@section('title', 'Laporan - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Laporan Perpustakaan</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                        <i class="bi bi-plus-circle me-2"></i>Generate Laporan
                    </button>
                    <button class="btn btn-outline-success">
                        <i class="bi bi-download me-2"></i>Export Semua
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.laporan.index') }}">
                        <div class="row align-items-center">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Periode</label>
                                        <select class="form-select" name="periode" id="periodFilter">
                                            <option value="today" {{ request('periode') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                            <option value="week" {{ request('periode') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                            <option value="month" {{ request('periode') == 'month' || !request('periode') ? 'selected' : '' }}>Bulan Ini</option>
                                            <option value="quarter" {{ request('periode') == 'quarter' ? 'selected' : '' }}>Kuartal Ini</option>
                                            <option value="year" {{ request('periode') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                                            <option value="custom" {{ request('periode') == 'custom' ? 'selected' : '' }}>Kustom</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Dari Tanggal</label>
                                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Sampai Tanggal</label>
                                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            <i class="bi bi-funnel me-2"></i>Terapkan Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="button" class="btn btn-outline-secondary" onclick="window.location.reload()">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Refresh Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-journal-arrow-up text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $stats['total_loans'] ?? 0 }}</h4>
                    <p class="text-muted mb-0">Peminjaman Periode Ini</p>
                    <small class="text-success">+{{ $stats['loan_growth'] ?? 0 }}% dari periode sebelumnya</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-return-left text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $stats['total_returns'] ?? 0 }}</h4>
                    <p class="text-muted mb-0">Pengembalian Periode Ini</p>
                    <small class="text-success">+{{ $stats['return_growth'] ?? 0 }}% dari periode sebelumnya</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $stats['overdue_count'] ?? 0 }}</h4>
                    <p class="text-muted mb-0">Keterlambatan</p>
                    <small class="text-danger">{{ $stats['overdue_change'] ?? 0 }} dari periode sebelumnya</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="bi bi-cash text-info" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">Rp {{ number_format($stats['total_fines'] ?? 0, 0, ',', '.') }}</h4>
                    <p class="text-muted mb-0">Denda Terkumpul</p>
                    <small class="text-info">Periode ini</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Trend Peminjaman & Pengembalian</h5>
                </div>
                <div class="card-body">
                    <canvas id="loanChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Kategori Populer</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Cards -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Buku Terpopuler</h5>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Dipinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($popular_books ?? [] as $index => $book)
                                <tr>
                                    <td><span class="badge bg-{{ $index == 0 ? 'warning' : 'secondary' }}">{{ $index + 1 }}</span></td>
                                    <td>{{ $book->judul }}</td>
                                    <td><span class="badge bg-info">{{ $book->kategori }}</span></td>
                                    <td>{{ $book->peminjamans_count }} kali</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data peminjaman</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Member Teraktif</h5>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Nama Member</th>
                                    <th>Jenis</th>
                                    <th>Total Pinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($active_members ?? [] as $index => $member)
                                <tr>
                                    <td><span class="badge bg-{{ $index == 0 ? 'warning' : 'secondary' }}">{{ $index + 1 }}</span></td>
                                    <td>{{ $member->nama }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($member->jenis_anggota) }}</span></td>
                                    <td>{{ $member->peminjamans_count }} buku</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data member</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Reports -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Laporan Detail</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-info btn-sm">
                                <i class="bi bi-printer me-2"></i>Print
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="bi bi-file-excel me-2"></i>Excel
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-file-pdf me-2"></i>PDF
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily" type="button">
                                <i class="bi bi-calendar-day me-2"></i>Harian
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button">
                                <i class="bi bi-calendar-month me-2"></i>Bulanan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="yearly-tab" data-bs-toggle="tab" data-bs-target="#yearly" type="button">
                                <i class="bi bi-calendar-range me-2"></i>Tahunan
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-3" id="reportTabContent">
                        <div class="tab-pane fade show active" id="daily" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Peminjaman Hari Ini</h6>
                                        <h3 class="text-primary">{{ $daily_stats['loans'] ?? 0 }}</h3>
                                        <small class="text-success">{{ $daily_stats['loans_change'] ?? 0 }} dari kemarin</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Pengembalian Hari Ini</h6>
                                        <h3 class="text-success">{{ $daily_stats['returns'] ?? 0 }}</h3>
                                        <small class="text-success">{{ $daily_stats['returns_change'] ?? 0 }} dari kemarin</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Keterlambatan</h6>
                                        <h3 class="text-danger">{{ $daily_stats['overdue'] ?? 0 }}</h3>
                                        <small class="text-danger">{{ $daily_stats['overdue_change'] ?? 0 }} dari kemarin</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="monthly" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Peminjaman Bulan Ini</h6>
                                        <h3 class="text-primary">{{ $monthly_stats['loans'] ?? 0 }}</h3>
                                        <small class="text-success">{{ $monthly_stats['loans_growth'] ?? 0 }}% dari bulan lalu</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Pengembalian Bulan Ini</h6>
                                        <h3 class="text-success">{{ $monthly_stats['returns'] ?? 0 }}</h3>
                                        <small class="text-success">{{ $monthly_stats['returns_growth'] ?? 0 }}% dari bulan lalu</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Total Denda</h6>
                                        <h3 class="text-warning">Rp {{ number_format($monthly_stats['fines'] ?? 0, 0, ',', '.') }}</h3>
                                        <small class="text-info">Total bulan ini</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="yearly" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Peminjaman Tahun Ini</h6>
                                        <h3 class="text-primary">{{ $yearly_stats['loans'] ?? 0 }}</h3>
                                        <small class="text-success">{{ $yearly_stats['loans_growth'] ?? 0 }}% dari tahun lalu</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Pengembalian Tahun Ini</h6>
                                        <h3 class="text-success">{{ $yearly_stats['returns'] ?? 0 }}</h3>
                                        <small class="text-success">{{ $yearly_stats['returns_growth'] ?? 0 }}% dari tahun lalu</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 mb-3">
                                        <h6 class="text-muted">Total Denda</h6>
                                        <h3 class="text-warning">Rp {{ number_format($yearly_stats['fines'] ?? 0, 0, ',', '.') }}</h3>
                                        <small class="text-info">Total tahun ini</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div class="modal fade" id="generateReportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Laporan Kustom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.laporan.export') }}" method="GET">
                        <div class="mb-3">
                            <label for="reportType" class="form-label">Jenis Laporan *</label>
                            <select class="form-select" name="type" id="reportType" required>
                                <option value="">Pilih Jenis Laporan...</option>
                                <option value="loans">Laporan Peminjaman</option>
                                <option value="returns">Laporan Pengembalian</option>
                                <option value="overdue">Laporan Keterlambatan</option>
                                <option value="members">Laporan Keanggotaan</option>
                                <option value="books">Laporan Koleksi Buku</option>
                                <option value="financial">Laporan Keuangan</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reportDateFrom" class="form-label">Dari Tanggal *</label>
                                <input type="date" class="form-control" name="date_from" id="reportDateFrom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="reportDateTo" class="form-label">Sampai Tanggal *</label>
                                <input type="date" class="form-control" name="date_to" id="reportDateTo" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reportFormat" class="form-label">Format Output *</label>
                            <select class="form-select" name="format" id="reportFormat" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_charts" value="1" id="includeCharts">
                                <label class="form-check-label" for="includeCharts">
                                    Sertakan grafik dan chart
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Generate Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Loan Chart
const loanCtx = document.getElementById('loanChart').getContext('2d');
const loanChart = new Chart(loanCtx, {
    type: 'line',
    data: {
        labels: @json($chart_data['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']),
        datasets: [{
            label: 'Peminjaman',
            data: @json($chart_data['loans'] ?? [45, 52, 48, 61, 55, 67, 73, 69, 78, 81, 76, 85]),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.1
        }, {
            label: 'Pengembalian',
            data: @json($chart_data['returns'] ?? [42, 48, 45, 58, 52, 63, 68, 66, 74, 77, 73, 82]),
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: {
        labels: @json($category_chart['labels'] ?? ['Teknologi', 'Fiksi', 'Sains', 'Sejarah', 'Ekonomi']),
        datasets: [{
            data: @json($category_chart['data'] ?? [35, 25, 20, 12, 8]),
            backgroundColor: [
                '#007bff',
                '#28a745',
                '#ffc107',
                '#dc3545',
                '#6f42c1'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
