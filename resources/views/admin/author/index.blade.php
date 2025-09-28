
@extends('layouts.app')

@section('title', 'Kelola Author - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Kelola Author</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kelola Author</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.author.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Author
                    </a>
                </div>
            </div>
        </div>
    </div>  

    <!-- Author Stats -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-person text-primary" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $authors->count() }}</h4>
                    <p class="text-muted mb-0">Total Author</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $authors->filter(function($a) { return !empty($a->email); })->count() }}</h4>
                    <p class="text-muted mb-0">Dengan Email</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $authors->sum(function($a) { return $a->bukus->count(); }) }}</h4>
                    <p class="text-muted mb-0">Total Buku</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up text-warning" style="font-size: 2rem;"></i>
                    <h4 class="mt-2 mb-1">{{ $authors->count() > 0 ? round($authors->sum(function($a) { return $a->bukus->count(); }) / $authors->count(), 1) : 0 }}</h4>
                    <p class="text-muted mb-0">Rata-rata Buku</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Author Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Author</h5>
                        <span class="text-muted">Total: {{ $authors->count() }} author</span>
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
                        <table class="table table-hover" id="DataTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Nama Author</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Biografi</th>
                                    <th scope="col">Jumlah Buku</th>
                                    <th scope="col">Terdaftar</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($authors as $author)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-person text-primary me-2"></i>
                                                <span class="fw-bold">{{ $author->nama_author }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $author->email ?: '-' }}</small>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $author->biografi ? Str::limit($author->biografi, 50) : '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $author->bukus->count() }} buku</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $author->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.author.edit', $author->author_id) }}">
                                                            <i class="bi bi-pencil me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" 
                                                                onclick="confirmDelete({{ $author->author_id }}, '{{ $author->nama_author }}')">
                                                            <i class="bi bi-trash me-2"></i>Hapus
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-person fs-1 d-block mb-2"></i>
                                                <p>Belum ada author terdaftar</p>
                                                <a href="{{ route('admin.author.create') }}" class="btn btn-primary">
                                                    <i class="bi bi-plus-circle me-2"></i>Tambah Author Pertama
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

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus author <strong id="authorName"></strong>?</p>
                    <p class="text-danger small">Aksi ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, nama) {
        document.getElementById('authorName').textContent = nama;
        document.getElementById('deleteForm').action = `/admin/author/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush
