<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Perpustakaan Digital</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- FontAwesome 6 (Latest) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">

  <!-- Navigation -->
  <nav class="bg-white shadow-lg border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
          <i class="fa-solid fa-book fa-2x text-blue-600 mr-3"></i>
          <h1 class="text-xl font-bold text-gray-900">Perpustakaan Digital</h1>
        </div>
        <div class="flex items-center space-x-4">
          <span class="text-gray-700">Selamat datang, {{ $userName }}</span>
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
              <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto py-6 px-4">
    
    @if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
      {{ session('success') }}
    </div>
    @endif

    <!-- Welcome Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, {{ $userName }}!</h2>
          <p class="text-gray-600">Selamat datang di Perpustakaan Digital. Temukan dan pinjam buku favorit Anda dengan mudah.</p>
        </div>
        <div class="hidden md:block">
          <i class="fas fa-user-graduate text-6xl text-blue-600 opacity-20"></i>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <!-- Buku Dipinjam -->
      <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-blue-100 text-sm font-medium">Buku Dipinjam</p>
            <p class="text-2xl font-bold">3</p>
          </div>
          <i class="fas fa-book-open text-3xl text-blue-200"></i>
        </div>
      </div>

      <!-- Riwayat Peminjaman -->
      <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm font-medium">Total Peminjaman</p>
            <p class="text-2xl font-bold">15</p>
          </div>
          <i class="fas fa-history text-3xl text-green-200"></i>
        </div>
      </div>

      <!-- Denda -->
      <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-yellow-100 text-sm font-medium">Denda Aktif</p>
            <p class="text-2xl font-bold">Rp 0</p>
          </div>
          <i class="fas fa-exclamation-triangle text-3xl text-yellow-200"></i>
        </div>
      </div>

      <!-- Status Keanggotaan -->
      <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-purple-100 text-sm font-medium">Status</p>
            <p class="text-2xl font-bold">Aktif</p>
          </div>
          <i class="fas fa-user-check text-3xl text-purple-200"></i>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Cari Buku -->
      <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          <i class="fas fa-search mr-2 text-blue-600"></i>Cari Buku
        </h3>
        <p class="text-gray-600 mb-4">Temukan buku yang ingin Anda pinjam</p>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
          Jelajahi Koleksi Buku
        </button>
      </div>

      <!-- Riwayat Peminjaman -->
      <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          <i class="fas fa-list mr-2 text-green-600"></i>Riwayat Peminjaman
        </h3>
        <p class="text-gray-600 mb-4">Lihat buku yang pernah Anda pinjam</p>
        <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
          Lihat Riwayat
        </button>
      </div>
    </div>

  </div>

</body>
</html>