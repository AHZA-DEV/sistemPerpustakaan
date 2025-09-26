
@extends('layouts.app')

@section('title', 'Kelola Anggota - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-2">Kelola Anggota</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Anggota</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Anggota
                    </a>
                </div>
            </div>

            <!-- Filter and Stats -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-select" id="statusFilter">
                                                <option value="">Semua Status</option>
                                                <option value="AKTIF">Aktif</option>
                                                <option value="NONAKTIF">Non-Aktif</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select" id="sortBy">
                                                <option value="nama">Urutkan: Nama</option>
                                                <option value="created_at">Urutkan: Terbaru</option>
                                                <option value="nisn_nim">Urutkan: NISN/NIM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-outline-success">
                                            <i class="bi bi-download me-2"></i>Export Excel
                                        </button>
                                        <button class="btn btn-outline-danger">
                                            <i class="bi bi-file-pdf me-2"></i>Export PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Members Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Daftar Anggota</h5>
                                <span class="text-muted">Total: {{ $anggotas->count() }} anggota</span>
                            </div>
                        </div>
                        <div class="card-body">
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

                            <div class="table-responsive">
                                <table class="table table-hover" id="usersTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">NISN/NIM</th>
                                            <th scope="col">Informasi Anggota</th>
                                            <th scope="col">Kontak</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Bergabung</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($anggotas as $anggota)
                                            <tr>
                                                <td>
                                                    <span class="fw-bold text-primary">{{ $anggota->nisn_nim }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6 class="mb-1">{{ $anggota->nama }}</h6>
                                                        <small class="text-muted">{{ $anggota->email }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="mb-1">
                                                            <i class="bi bi-telephone me-1"></i>
                                                            <small>{{ $anggota->telepon }}</small>
                                                        </div>
                                                        <div>
                                                            <i class="bi bi-geo-alt me-1"></i>
                                                            <small class="text-muted">{{ Str::limit($anggota->alamat, 30) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($anggota->status_keanggotaan === 'AKTIF')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Non-Aktif</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $anggota->created_at->format('d M Y') }}</small>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('admin.users.edit', $anggota) }}">
                                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('admin.users.destroy', $anggota) }}" method="POST" 
                                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="bi bi-trash me-2"></i>Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                                        <p>Belum ada anggota terdaftar</p>
                                                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                                            <i class="bi bi-plus-circle me-2"></i>Tambah Anggota Pertama
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
    </div>
</div>

@push('scripts')
<script>
    // Simple table filtering
    document.getElementById('statusFilter').addEventListener('change', function() {
        // Add filtering logic here if needed
    });
</script>
@endpush
@endsection
