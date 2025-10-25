<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('cek_koneksi');

// Home (index.php)
Route::get('/', [SiteController::class, 'index'])->name('home');

// Struktur Organisasi (struktur.php)
Route::get('/struktur', [SiteController::class, 'strukturOrganisasi'])->name('struktur');

// Layanan Umum (layanan.php)
Route::get('/layanan', [SiteController::class, 'layananUmum'])->name('layanan');

// Visi Misi & Tujuan (visi.php)
Route::get('/visimisi', [SiteController::class, 'visiMisi'])->name('visimisi');

// Login
Route::get('/login', [SiteController::class, 'login'])->name('login');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::resource('jenish', JenisHewanController::class, ['as' => 'admin']);
    Route::resource('kategori', KategoriController::class, ['as' => 'admin']);
    Route::resource('kategoriklinis', KategoriKlinisController::class, ['as' => 'admin']);
    Route::resource('kodetindakanterapi', KodeTindakanTerapiController::class, ['as' => 'admin']);
    Route::resource('pemilik', PemilikController::class, ['as' => 'admin']);
    Route::resource('rashewan', RasHewanController::class, ['as' => 'admin']);
    Route::resource('role', RoleController::class, ['as' => 'admin']);
    Route::resource('user', UserController::class, ['as' => 'admin']);
});
