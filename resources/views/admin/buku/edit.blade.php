@extends('layouts.app')

@section('title', 'Edit Buku - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Edit Buku</h2>
                    <p class="text-muted mb-0">Edit informasi buku: {{ $buku->judul }}</p>
                </div>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Form Edit Buku</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.buku.update', $buku) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="judul" class="form-label">Judul Buku *</label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                               id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="isbn" class="form-label">ISBN *</label>
                                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                               id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}" required>
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kategori" class="form-label">Kategori *</label>
                                        <select class="form-select @error('kategori') is-invalid @enderror" 
                                                id="kategori" name="kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->nama_kategori }}" 
                                                        {{ old('kategori', $buku->kategori) == $kategori->nama_kategori ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="penerbit_id" class="form-label">Penerbit *</label>
                                        <select class="form-select @error('penerbit_id') is-invalid @enderror" 
                                                id="penerbit_id" name="penerbit_id" required>
                                            <option value="">Pilih Penerbit</option>
                                            @foreach($penerbits as $penerbit)
                                                <option value="{{ $penerbit->penerbit_id }}" 
                                                        {{ old('penerbit_id', $buku->penerbit_id) == $penerbit->penerbit_id ? 'selected' : '' }}>
                                                    {{ $penerbit->nama_penerbit }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('penerbit_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="authors" class="form-label">Author *</label>
                                    <select class="form-select @error('authors') is-invalid @enderror" 
                                            id="authors" name="authors[]" multiple required>
                                        @foreach($authors as $author)
                                            <option value="{{ $author->author_id }}" 
                                                    {{ in_array($author->author_id, old('authors', $buku->authors->pluck('author_id')->toArray())) ? 'selected' : '' }}>
                                                {{ $author->nama_author }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Tahan Ctrl untuk memilih multiple author</div>
                                    @error('authors')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tahun_terbit" class="form-label">Tahun Terbit *</label>
                                        <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" 
                                               id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" 
                                               min="1900" max="{{ date('Y') }}" required>
                                        @error('tahun_terbit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="stok" class="form-label">Stok *</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                               id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" min="0" required>
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Update Buku
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
