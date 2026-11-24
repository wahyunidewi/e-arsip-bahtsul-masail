<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\arsipbahtsulmasailController;

// Rute Publik Utama, Filter Kategori & Pencarian
Route::get('/', [arsipbahtsulmasailController::class, 'indexPublic'])->name('home');
Route::get('/kategori/{kategori}', [arsipbahtsulmasailController::class, 'byKategori'])->name('arsip.kategori');
Route::get('/cari', [arsipbahtsulmasailController::class, 'searchPublic'])->name('arsip.cari');

// Rute Autentikasi Admin
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Khusus Admin yang Harus Login
Route::middleware(['auth'])->prefix('arsip')->name('arsip.')->group(function () {
    Route::get('/', [arsipbahtsulmasailController::class, 'index'])->name('index');
    Route::get('/tambah', [arsipbahtsulmasailController::class, 'create'])->name('create');
    Route::post('/', [arsipbahtsulmasailController::class, 'store'])->name('store');
    Route::post('/preview-klasifikasi', [arsipbahtsulmasailController::class, 'previewKlasifikasi'])->name('previewKlasifikasi');

    Route::get('/{id}/edit', [arsipbahtsulmasailController::class, 'edit'])->name('edit');
    Route::put('/{id}', [arsipbahtsulmasailController::class, 'update'])->name('update');
    Route::delete('/{id}', [arsipbahtsulmasailController::class, 'destroy'])->name('destroy');
});