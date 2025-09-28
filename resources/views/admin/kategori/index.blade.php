
@extends('layouts.app')

@section('title', 'Kelola Kategori - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Kelola Kategori</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Kategori</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Category Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-tags text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $kategoris->count() }}</h4>
                    <p class="text-muted mb-0">Total Kategori</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ \App\Models\Buku::count() }}</h4>
                    <p class="text-muted mb-0">Total Buku</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $kategoris->count() > 0 ? number_format(\App\Models\Buku::count() / $kategoris->count()) : 0 }}</h4>
                    <p class="text-muted mb-0">Rata-rata per Kategori</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-plus text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ \App\Models\Kategori::whereDate('created_at', '>=', now()->subMonth())->count() }}</h4>
                    <p class="text-muted mb-0">Kategori Baru (Bulan Ini)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($kategoris as $kategori)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-info h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <i class="bi bi-tag text-info" style="font-size: 2rem;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-1">{{ $kategori->nama_kategori }}</h5>
                                            <p class="text-muted mb-0">{{ Str::limit($kategori->deskripsi, 50) }}</p>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-link btn-sm" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('admin.kategori.edit', $kategori->kategori_id) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="{{ route('admin.buku.index') }}?kategori={{ $kategori->nama_kategori }}"><i class="bi bi-eye me-2"></i>Lihat Buku</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.kategori.destroy', $kategori->kategori_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-info">{{ $kategori->bukus->count() }} Buku</span>
                                        <span class="badge bg-success">Aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-4">
                                <i class="bi bi-folder-x" style="font-size: 3rem; color: #ccc;"></i>
                                <h4 class="mt-3 text-muted">Belum Ada Kategori</h4>
                                <p class="text-muted">Silakan tambahkan kategori baru untuk memulai.</p>
                                <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Semua Kategori</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="kategorisTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Jumlah Buku</th>
                                    <th scope="col">Dibuat</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategoris as $kategori)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-tag text-info me-2"></i>
                                            <span class="fw-bold">{{ $kategori->nama_kategori }}</span>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($kategori->deskripsi, 100) }}</td>
                                    <td><span class="badge bg-info">{{ $kategori->bukus->count() }}</span></td>
                                    <td>{{ $kategori->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.kategori.edit', $kategori->kategori_id) }}" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.buku.index') }}?kategori={{ $kategori->nama_kategori }}" class="btn btn-outline-info" title="Lihat Buku">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.kategori.destroy', $kategori->kategori_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada kategori</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#kategorisTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "search": "Cari:",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            },
            "loadingRecords": "Memuat...",
            "processing": "Sedang memproses..."
        }
    });
});
</script>
@endpush
