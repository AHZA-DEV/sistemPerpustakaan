
@extends('layouts.app')

@section('title', 'Hapus Penerbit - Admin')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Hapus Penerbit</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.penerbit.index') }}">Kelola Penerbit</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hapus Penerbit</li>
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
                        <p class="mb-0">Anda akan menghapus penerbit <strong>"{{ $penerbit->nama_penerbit }}"</strong>. Aksi ini tidak dapat dibatalkan!</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Penerbit:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Nama:</strong> {{ $penerbit->nama_penerbit }}</li>
                                <li><strong>Email:</strong> {{ $penerbit->email ?: 'Tidak ada' }}</li>
                                <li><strong>Telepon:</strong> {{ $penerbit->telepon ?: 'Tidak ada' }}</li>
                                <li><strong>Alamat:</strong> {{ $penerbit->alamat ?: 'Tidak ada' }}</li>
                                <li><strong>Terdaftar:</strong> {{ $penerbit->created_at->format('d M Y H:i') }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Dampak Penghapusan:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Jumlah Buku Terkait:</strong> {{ $penerbit->bukus->count() }} buku</li>
                                @if($penerbit->bukus->count() > 0)
                                    <li class="text-danger">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        Penerbit ini tidak dapat dihapus karena masih memiliki buku terkait
                                    </li>
                                @else
                                    <li class="text-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Penerbit ini dapat dihapus dengan aman
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    @if($penerbit->bukus->count() > 0)
                        <div class="alert alert-warning mt-3" role="alert">
                            <h6 class="alert-heading">Tidak Dapat Menghapus</h6>
                            <p class="mb-2">Penerbit ini masih digunakan oleh {{ $penerbit->bukus->count() }} buku:</p>
                            <ul class="mb-0">
                                @foreach($penerbit->bukus->take(5) as $buku)
                                    <li>{{ $buku->judul }}</li>
                                @endforeach
                                @if($penerbit->bukus->count() > 5)
                                    <li>... dan {{ $penerbit->bukus->count() - 5 }} buku lainnya</li>
                                @endif
                            </ul>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.penerbit.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                            <a href="{{ route('admin.penerbit.edit', $penerbit->penerbit_id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil me-2"></i>Edit Penerbit
                            </a>
                        </div>
                    @else
                        <form action="{{ route('admin.penerbit.destroy', $penerbit->penerbit_id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.penerbit.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus penerbit ini?')">
                                    <i class="bi bi-trash me-2"></i>Ya, Hapus Penerbit
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
