
@extends('layouts.app')

@section('title', 'Kelola Buku - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Kelola Buku</h2>
                    <p class="text-muted mb-0">Kelola koleksi buku perpustakaan</p>
                </div>
                <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card stat-card-blue">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-white-50">Total Buku</h6>
                            <h2 class="card-title text-white mb-2">{{ $bukus->total() }}</h2>
                            <small class="text-white-50">Seluruh koleksi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card stat-card-purple">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-white-50">Buku Tersedia</h6>
                            <h2 class="card-title text-white mb-2">{{ $bukus->where('stok', '>', 0)->count() }}</h2>
                            <small class="text-white-50">Siap dipinjam</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Books Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Buku</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped" id="booksTable">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>ISBN</th>
                                    <th>Author</th>
                                    <th>Kategori</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bukus as $buku)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $buku->judul }}</div>
                                    </td>
                                    <td>{{ $buku->isbn }}</td>
                                    <td>{{ $buku->authors_name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $buku->kategori }}</span>
                                    </td>
                                    <td>{{ $buku->penerbit->nama_penerbit ?? '-' }}</td>
                                    <td>{{ $buku->tahun_terbit }}</td>
                                    <td>
                                        <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $buku->stok }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($buku->isAvailable())
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('admin.buku.edit', $buku) }}">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.buku.destroy', $buku) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                                            <i class="bi bi-trash me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bukus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#booksTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "paging": false,
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
            }
        }
    });
});
</script>
@endpush
@endsection
