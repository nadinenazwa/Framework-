<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\DashboardController;
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
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Perawat\AntrianController;
use App\Http\Controllers\Perawat\PasienController;
use App\Http\Controllers\Pemilik\DashboardPemilikController;

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('cek_koneksi');

// Home (index.php)
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/home', function () { return redirect('/'); });

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
Route::prefix('admin')->middleware(['auth', 'isAdministrator'])->name('admin.')->group(function () {
    // Dashboard
     // Redirect base to dashboard
     Route::get('/', function () { return redirect()->route('admin.dashboard'); });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data Routes
    Route::resource('jenish', JenisHewanController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('kategoriklinis', KategoriKlinisController::class);
    Route::resource('kodetindakanterapi', KodeTindakanTerapiController::class);
    Route::resource('rashewan', RasHewanController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('pemilik', PemilikController::class);
    Route::resource('pet', PetController::class);
});

// Resepsionis routes - Grouped with isResepsionis middleware
Route::prefix('resepsionis')->middleware(['auth', 'isResepsionis'])->name('resepsionis.')->group(function () {
     // Redirect base to dashboard
     Route::get('/', function () { return redirect()->route('resepsionis.dashboard'); });
    
    // Rute untuk halaman dashboard utama (yang ada kartu)
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])
         ->name('dashboard');

    // Rute untuk daftar temu dokter
    Route::get('/temu-dokter', [TemuDokterController::class, 'index'])
         ->name('temu_dokter.index');

    // Rute resource untuk Pemilik
    Route::resource('pemilik', PemilikResepsionisController::class)
         ->only(['index', 'show']);
    
    // Rute resource untuk Pet
    Route::resource('pet', PetResepsionisController::class)
         ->only(['index', 'show']);
});

// Dokter routes - Grouped with isDokter middleware
Route::prefix('dokter')->middleware(['auth', 'isDokter'])->name('dokter.')->group(function () {
    // Redirect base to dashboard
    Route::get('/', function () { return redirect()->route('dokter.dashboard'); });

    Route::get('/dashboard', [DashboardDokterController::class, 'index'])
         ->name('dashboard');
    Route::get('/pasien/{pet}/rekam-medis', [DashboardDokterController::class, 'showRekamMedis'])
         ->name('rekam_medis.index');
});

// Perawat routes - Grouped with isPerawat middleware
Route::prefix('perawat')->middleware(['auth', 'isPerawat'])->name('perawat.')->group(function () {
    // Redirect base to dashboard
    Route::get('/', function () { return redirect()->route('perawat.dashboard'); });

    // Rute untuk halaman dashboard utama (dengan kartu)
    Route::get('/dashboard', [DashboardPerawatController::class, 'index'])
         ->name('dashboard');

    // Rute untuk "Daftar Semua Temu Dokter"
    Route::get('/antrian', [AntrianController::class, 'index'])
         ->name('antrian.index');

    // Rute untuk "Daftar Semua Pasien" (untuk melihat rekam medis)
    Route::get('/pasien', [PasienController::class, 'index'])
         ->name('pasien.index');

    // Rute untuk "Detail Rekam Medis" per pasien
    Route::get('/pasien/{pet}', [PasienController::class, 'show'])
         ->name('pasien.show');
}); 

// Pemilik routes - Grouped with isPemilik middleware
Route::prefix('pemilik')->middleware(['auth', 'isPemilik'])->name('pemilik.')->group(function () {
    // Redirect base to dashboard
    Route::get('/', function () { return redirect()->route('pemilik.dashboard'); });
    
    // Rute untuk halaman dashboard utama (menampilkan daftar pet milik pemilik)
    Route::get('/dashboard', [DashboardPemilikController::class, 'index'])
         ->name('dashboard');

    // Rute untuk melihat riwayat rekam medis satu pet
    Route::get('/pet/{pet}/rekam-medis', [DashboardPemilikController::class, 'showRekamMedis'])
         ->name('rekam_medis.show');
});