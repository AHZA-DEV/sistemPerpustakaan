@extends('layouts.app')

@section('title', 'Dashboard - Anggota')

@section('content')
  <!-- Welcome Section -->
  <div class="row mb-4">
    <div class="col-6">
      <div class="welcome-section">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h2 class="mb-2">Selamat Datang, John Doe</h2>
            <p class="text-muted">Dashboard Perpustakaan Digital untuk Anggota. Jelajahi koleksi buku dan kelola
              peminjaman Anda.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 mb-8">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Peminjaman Aktif</h5>
            <a href="my-loans.html" class="text-primary text-decoration-none">Lihat Semua</a>
          </div>
        </div>
        <div class="card-body">
          <div class="loan-list">
            <div class="d-flex align-items-center mb-3">
              <img src="https://via.placeholder.com/50x65/007bff/ffffff?text=Book" alt="Book Cover" class="me-3 rounded"
                style="width: 40px; height: 52px;">
              <div class="flex-grow-1 card-title">
                <div class="fw-bold">Clean Code</div>
                <small class="text-muted">Jatuh tempo: 29 Jan 2024</small>
              </div>
              <span class="badge bg-success">Aktif</span>
            </div>
            <div class="d-flex align-items-center mb-3">
              <img src="https://via.placeholder.com/50x65/28a745/ffffff?text=Book" alt="Book Cover" class="me-3 rounded"
                style="width: 40px; height: 52px;">
              <div class="flex-grow-1 card-title">
                <div class="fw-bold">JavaScript Guide</div>
                <small class="text-muted">Jatuh tempo: 25 Jan 2024</small>
              </div>
              <span class="badge bg-warning">Hampir Jatuh Tempo</span>
            </div>
            <div class="d-flex align-items-center">
              <img src="https://via.placeholder.com/50x65/dc3545/ffffff?text=Book" alt="Book Cover" class="me-3 rounded"
                style="width: 40px; height: 52px;">
              <div class="flex-grow-1 card-title">
                <div class="fw-bold">Design Patterns</div>
                <small class="text-muted">Jatuh tempo: 02 Feb 2024</small>
              </div>
              <span class="badge bg-success">Aktif</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection