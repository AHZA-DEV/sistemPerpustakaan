
@extends('layouts.app')

@section('title', 'Detail Buku - ' . $buku->judul)

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Detail Buku</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.buku.index') }}">Semua Buku</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($buku->judul, 30) }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('user.buku.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Book Detail Content -->
    <div class="row">
        <!-- Book Cover and Basic Info -->
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <!-- Book Cover -->
                    <img src="https://via.placeholder.com/300x400/{{ collect(['007bff', '28a745', 'dc3545', '6366f1', 'f59e0b'])->random() }}/ffffff?text={{ urlencode(Str::upper(Str::limit($buku->judul, 8, ''))) }}" 
                         alt="Cover {{ $buku->judul }}" 
                         class="img-fluid rounded shadow mb-4" 
                         style="max-width: 250px; max-height: 350px;">
                    
                    <!-- Book ID -->
                    <h6 class="text-muted mb-3">ID Buku: <span class="fw-bold text-primary">BK{{ str_pad($buku->buku_id, 3, '0', STR_PAD_LEFT) }}</span></h6>
                    
                    <!-- Availability Status -->
                    <div class="mb-3">
                        @if($buku->stok > 5)
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="bi bi-check-circle me-2"></i>Tersedia ({{ $buku->stok }} eksemplar)
                            </span>
                        @elseif($buku->stok > 0)
                            <span class="badge bg-warning fs-6 px-3 py-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>Stok Terbatas ({{ $buku->stok }} eksemplar)
                            </span>
                        @else
                            <span class="badge bg-danger fs-6 px-3 py-2">
                                <i class="bi bi-x-circle me-2"></i>Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <!-- Borrow Button -->
                    @if($buku->stok > 0)
                        <button class="btn btn-primary btn-lg w-100" onclick="borrowBook({{ $buku->buku_id }})">
                            <i class="bi bi-bookmark-plus me-2"></i>Pinjam Buku Ini
                        </button>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="bi bi-bookmark-plus me-2"></i>Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="col-lg-8 col-md-7">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Buku</h5>
                </div>
                <div class="card-body">
                    <!-- Book Title -->
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-2">{{ $buku->judul }}</h2>
                        <p class="text-muted lead">oleh {{ $buku->authors->pluck('nama_author')->join(', ') ?: 'Penulis tidak diketahui' }}</p>
                    </div>

                    <!-- Book Information Table -->
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-muted" style="width: 25%;">ISBN:</td>
                                    <td>{{ $buku->isbn }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Kategori:</td>
                                    <td>
                                        <span class="badge bg-info text-white px-3 py-2">{{ $buku->kategori }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Penerbit:</td>
                                    <td>{{ $buku->penerbit->nama_penerbit ?? 'Tidak diketahui' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Tahun Terbit:</td>
                                    <td>{{ $buku->tahun_terbit }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Stok Tersedia:</td>
                                    <td>
                                        <span class="fw-bold {{ $buku->stok > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $buku->stok }} eksemplar
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Authors Section -->
                    @if($buku->authors->count() > 0)
                        <div class="mt-4">
                            <h6 class="fw-bold text-muted mb-3">Pengarang:</h6>
                            <div class="row">
                                @foreach($buku->authors as $author)
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $author->nama_author }}</div>
                                                @if($author->email)
                                                    <small class="text-muted">{{ $author->email }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Publisher Info -->
                    @if($buku->penerbit)
                        <div class="mt-4">
                            <h6 class="fw-bold text-muted mb-3">Informasi Penerbit:</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $buku->penerbit->nama_penerbit }}</h6>
                                    @if($buku->penerbit->alamat)
                                        <p class="card-text mb-1">
                                            <i class="bi bi-geo-alt me-2"></i>{{ $buku->penerbit->alamat }}
                                        </p>
                                    @endif
                                    @if($buku->penerbit->telepon)
                                        <p class="card-text mb-1">
                                            <i class="bi bi-telephone me-2"></i>{{ $buku->penerbit->telepon }}
                                        </p>
                                    @endif
                                    @if($buku->penerbit->email)
                                        <p class="card-text mb-0">
                                            <i class="bi bi-envelope me-2"></i>{{ $buku->penerbit->email }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Related Books Section -->
    @if($relatedBooks->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Buku Terkait (Kategori: {{ $buku->kategori }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($relatedBooks as $related)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body text-center">
                                            <img src="https://via.placeholder.com/120x160/{{ collect(['007bff', '28a745', 'dc3545', '6366f1', 'f59e0b'])->random() }}/ffffff?text={{ urlencode(Str::upper(Str::limit($related->judul, 3, ''))) }}" 
                                                 alt="Cover" class="mb-3 rounded" style="width: 80px; height: 104px;">
                                            <h6 class="card-title">{{ Str::limit($related->judul, 25) }}</h6>
                                            <p class="card-text text-muted small">{{ $related->authors->pluck('nama_author')->join(', ') }}</p>
                                            <div class="mt-2">
                                                <a href="{{ route('user.buku.detail', $related->buku_id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </a>
                                                @if($related->stok > 0)
                                                    <button class="btn btn-sm btn-success" onclick="borrowBook({{ $related->buku_id }})">
                                                        <i class="bi bi-bookmark-plus"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    function borrowBook(bookId) {
        if (confirm('Apakah Anda yakin ingin meminjam buku ini?')) {
            fetch('/user/books/borrow', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    buku_id: bookId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses permintaan');
            });
        }
    }
</script>
@endpush
