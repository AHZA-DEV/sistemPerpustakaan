<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\UserBukuController; // Import UserBukuController
use App\Http\Controllers\UserPeminjamanController; // Import UserPeminjamanController

// Login routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Buku routes
    Route::resource('buku', BukuController::class);

    // Kategori routes
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Penerbit routes
    Route::get('/penerbit', [PenerbitController::class, 'index'])->name('penerbit.index');
    Route::get('/penerbit/create', [PenerbitController::class, 'create'])->name('penerbit.create');
    Route::post('/penerbit', [PenerbitController::class, 'store'])->name('penerbit.store');
    Route::get('/penerbit/{id}/edit', [PenerbitController::class, 'edit'])->name('penerbit.edit');
    Route::put('/penerbit/{id}', [PenerbitController::class, 'update'])->name('penerbit.update');
    Route::delete('/penerbit/{id}', [PenerbitController::class, 'destroy'])->name('penerbit.destroy');

    // Author routes
    Route::get('/author', [\App\Http\Controllers\AuthorController::class, 'index'])->name('author.index');
    Route::get('/author/create', [\App\Http\Controllers\AuthorController::class, 'create'])->name('author.create');
    Route::post('/author', [\App\Http\Controllers\AuthorController::class, 'store'])->name('author.store');
    Route::get('/author/{id}/edit', [\App\Http\Controllers\AuthorController::class, 'edit'])->name('author.edit');
    Route::put('/author/{id}', [\App\Http\Controllers\AuthorController::class, 'update'])->name('author.update');
    Route::delete('/author/{id}', [\App\Http\Controllers\AuthorController::class, 'destroy'])->name('author.destroy');

    // Peminjaman routes
    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('peminjaman/{peminjaman}/return', [PeminjamanController::class, 'returnBook'])->name('peminjaman.return');

    // Users (Anggota) routes
    Route::resource('users', AnggotaController::class);

    // Laporan routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
});

// User routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [UserBukuController::class, 'index'])->name('buku.index');
    Route::get('/books/{id}', [UserBukuController::class, 'show'])->name('buku.show');
    Route::get('/books/{id}/detail', [UserBukuController::class, 'detail'])->name('buku.detail');
    Route::post('/books/borrow', [UserPeminjamanController::class, 'store'])->name('buku.borrow');
    Route::get('/loans', [UserPeminjamanController::class, 'index'])->name('loans.index');
});