
@extends('layouts.app')

@section('title', 'Hapus Author - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Hapus Author</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.author.index') }}">Kelola Author</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hapus Author</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Section -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Penghapusan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        <h6 class="alert-heading">Peringatan!</h6>
                        <p class="mb-0">Anda akan menghapus author <strong>"{{ $author->nama_author }}"</strong>. Aksi ini tidak dapat dibatalkan!</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Author:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Nama:</strong> {{ $author->nama_author }}</li>
                                <li><strong>Email:</strong> {{ $author->email ?: 'Tidak ada' }}</li>
                                <li><strong>Biografi:</strong> {{ $author->biografi ? Str::limit($author->biografi, 100) : 'Tidak ada' }}</li>
                                <li><strong>Terdaftar:</strong> {{ $author->created_at->format('d M Y H:i') }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Dampak Penghapusan:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Jumlah Buku Terkait:</strong> {{ $author->bukus->count() }} buku</li>
                                @if($author->bukus->count() > 0)
                                    <li class="text-danger">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        Author ini tidak dapat dihapus karena masih memiliki buku terkait
                                    </li>
                                @else
                                    <li class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Author ini dapat dihapus dengan aman
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    @if($author->bukus->count() > 0)
                        <div class="alert alert-warning mt-3" role="alert">
                            <h6 class="alert-heading">Tidak Dapat Menghapus</h6>
                            <p class="mb-2">Author ini masih digunakan oleh {{ $author->bukus->count() }} buku:</p>
                            <ul class="mb-0">
                                @foreach($author->bukus->take(5) as $buku)
                                    <li>{{ $buku->judul }}</li>
                                @endforeach
                                @if($author->bukus->count() > 5)
                                    <li>... dan {{ $author->bukus->count() - 5 }} buku lainnya</li>
                                @endif
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.author.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                            <a href="{{ route('admin.author.edit', $author->author_id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Author
                            </a>
                        </div>
                    @else
                        <form action="{{ route('admin.author.destroy', $author->author_id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.author.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus author ini?')">
                                    <i class="bi bi-trash me-2"></i>Ya, Hapus Author
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
