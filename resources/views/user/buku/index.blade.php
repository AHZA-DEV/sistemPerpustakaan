@extends('layouts.app')

@section('title', 'Semua Buku - User Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Semua Buku</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Semua Buku</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Cari buku..." id="searchInput">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="categoryFilter">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="sortBy">
                                <option value="judul">Urutkan: Judul</option>
                                <option value="tahun_terbit">Urutkan: Tahun Terbit</option>
                                <option value="author">Urutkan: Pengarang</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary w-100" onclick="resetFilters()">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Buku</h5>
                        <span class="text-muted">Total: {{ $bukus->count() }} buku</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="booksTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Cover</th>
                                    <th scope="col">ID Buku</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Pengarang</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Penerbit</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bukus as $buku)
                                    <tr>
                                        <td>
                                            <img src="https://via.placeholder.com/40x50/{{ collect(['007bff', '28a745', 'dc3545', '6366f1', 'f59e0b'])->random() }}/ffffff?text={{ Str::upper(Str::limit($buku->judul, 2, '')) }}"
                                                alt="Cover" class="rounded" width="40" height="50">
                                        </td>
                                        <td>
                                            <span
                                                class="fw-bold text-primary">BK{{ str_pad($buku->buku_id, 3, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold">{{ $buku->judul }}</div>
                                                <small class="text-muted">ISBN: {{ $buku->isbn }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $buku->authors->pluck('nama_author')->join(', ') ?: 'N/A' }}</td>
                                        <td><span class="badge bg-info">{{ $buku->kategori }}</span></td>
                                        <td>{{ $buku->tahun_terbit }}</td>
                                        <td>{{ $buku->penerbit->nama_penerbit ?? 'N/A' }}</td>
                                        <td>
                                            @if($buku->stok > 5)
                                                <span class="badge bg-success">Tersedia ({{ $buku->stok }})</span>
                                            @elseif($buku->stok > 0)
                                                <span class="badge bg-warning">Stok Terbatas ({{ $buku->stok }})</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tersedia (0)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#bookModal" onclick="showBookDetails({{ $buku->buku_id }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @if($buku->stok > 0)
                                                    <button class="btn btn-sm btn-success"
                                                        onclick="borrowBook({{ $buku->buku_id }})">
                                                        <i class="bi bi-bookmark-plus"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        <i class="bi bi-bookmark-plus"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-book fs-1 d-block mb-2"></i>
                                                <p>Belum ada buku tersedia</p>
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

    <!-- Book Detail Modal -->
    <div class="modal fade" id="bookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="bookModalBody">
                    <!-- Content will be loaded here -->
                    <!-- Book Detail Content -->
                    <div class="row">
                        <!-- Book Cover and Basic Info -->
                        <div class="col-lg-4 col-md-5 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <!-- Book Cover -->
                                    <img src="https://via.placeholder.com/300x400/{{ collect(['007bff', '28a745', 'dc3545', '6366f1', 'f59e0b'])->random() }}/ffffff?text={{ urlencode(Str::upper(Str::limit($buku->judul, 8, ''))) }}"
                                        alt="Cover {{ $buku->judul }}" class="img-fluid rounded shadow mb-4"
                                        style="max-width: 250px; max-height: 350px;">

                                    <!-- Book ID -->
                                    <h6 class="text-muted mb-3">ID Buku: <span
                                            class="fw-bold text-primary">BK{{ str_pad($buku->buku_id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </h6>
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
                                        <p class="text-muted lead">oleh
                                            {{ $buku->authors->pluck('nama_author')->join(', ') ?: 'Penulis tidak diketahui' }}
                                        </p>
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
                                                        <span
                                                            class="badge bg-info text-white px-3 py-2">{{ $buku->kategori }}</span>
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
                                                        <span
                                                            class="fw-bold {{ $buku->stok > 0 ? 'text-success' : 'text-danger' }}">
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
                                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                                style="width: 40px; height: 40px;">
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
                                            <div class="card">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="borrowBookModalBtn" style="display: none;">
                        <i class="bi bi-bookmark-plus me-2"></i>Pinjam Buku
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentBookId = null;

        function showBookDetails(bookId) {
            currentBookId = bookId;

            fetch(`/user/books/${bookId}`)
                .then(response => response.json())
                .then(data => {
                    const modalBody = document.getElementById('bookModalBody');
                    const borrowBtn = document.getElementById('borrowBookModalBtn');

                    modalBody.innerHTML = `
                        <div class="row">
                            <div class="col-md-4">
                                <img src="https://via.placeholder.com/300x400/007bff/ffffff?text=Book+Cover" alt="Book Cover" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <h4>${data.judul}</h4>
                                <p class="text-muted">${data.authors}</p>

                                <div class="mb-3">
                                    <span class="badge bg-info me-2">${data.kategori}</span>
                                    <span class="badge bg-${data.available ? 'success' : 'danger'}">${data.available ? 'Tersedia' : 'Tidak Tersedia'}</span>
                                </div>

                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>ISBN:</strong></td>
                                        <td>${data.isbn}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Penerbit:</strong></td>
                                        <td>${data.penerbit}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tahun:</strong></td>
                                        <td>${data.tahun_terbit}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Stok:</strong></td>
                                        <td>${data.stok} tersedia</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    `;

                    if (data.available) {
                        borrowBtn.style.display = 'inline-block';
                        borrowBtn.onclick = () => borrowBook(bookId);
                    } else {
                        borrowBtn.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('bookModalBody').innerHTML = '<p class="text-danger">Error loading book details</p>';
                });
        }

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

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('sortBy').value = 'judul';
            filterTable();
        }

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const rows = document.querySelectorAll('#booksTable tbody tr');

            rows.forEach(row => {
                const title = row.cells[2].textContent.toLowerCase();
                const author = row.cells[3].textContent.toLowerCase();
                const category = row.cells[4].textContent;

                const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
                const matchesCategory = !categoryFilter || category.includes(categoryFilter);

                row.style.display = matchesSearch && matchesCategory ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('keyup', filterTable);
        document.getElementById('categoryFilter').addEventListener('change', filterTable);
    </script>
@endpush