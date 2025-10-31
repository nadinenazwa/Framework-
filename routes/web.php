<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;
use App\Http\Controllers\Resepsionis\PemilikResepsionisController;
use App\Http\Controllers\Resepsionis\PetResepsionisController;
use App\Http\Controllers\Resepsionis\TemuDokterController;
use App\Http\Controllers\Dokter\DashboardDokterController;

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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('jenish', JenisHewanController::class, ['as' => 'admin']);
    Route::resource('kategori', KategoriController::class, ['as' => 'admin']);
    Route::resource('kategoriklinis', KategoriKlinisController::class, ['as' => 'admin']);
    Route::resource('kodetindakanterapi', KodeTindakanTerapiController::class, ['as' => 'admin']);
    Route::resource('pemilik', PemilikController::class, ['as' => 'admin']);
    Route::resource('rashewan', RasHewanController::class, ['as' => 'admin']);
    Route::resource('role', RoleController::class, ['as' => 'admin']);
    Route::resource('user', UserController::class, ['as' => 'admin']);
    Route::resource('pet', PetController::class, ['as' => 'admin']);
});

// Resepsionis routes
Route::prefix('resepsionis')->middleware(['auth'])->group(function () {
    
    // Rute untuk halaman dashboard utama (yang ada kartu)
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])
         ->name('resepsionis.dashboard');

    // Rute untuk daftar temu dokter
    Route::get('/temu-dokter', [TemuDokterController::class, 'index'])
         ->name('resepsionis.temu_dokter.index');

    // Rute resource untuk Pemilik
    Route::resource('pemilik', PemilikResepsionisController::class, ['as' => 'resepsionis'])
         ->only(['index', 'show']);
    
    // Rute resource untuk Pet
    Route::resource('pet', PetResepsionisController::class, ['as' => 'resepsionis'])
         ->only(['index', 'show']);
});

// Dokter routes
Route::prefix('dokter')->middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardDokterController::class, 'index'])
         ->name('dokter.dashboard');
    Route::get('/pasien/{pet}/rekam-medis', [DashboardDokterController::class, 'showRekamMedis'])
         ->name('dokter.rekam_medis.index');
});

// Perawat routes
Route::prefix('perawat')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('perawat.dashboard');
    })->name('perawat.dashboard');
    Route::resource('pet', PetController::class, ['as' => 'perawat']);
}); 
// Pemilik routes
Route::prefix('pemilik')->middleware(['auth'])->group(function () {
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
