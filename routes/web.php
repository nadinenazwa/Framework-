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
use App\Http\Controllers\Admin\DokterController; 
use App\Http\Controllers\Admin\PerawatController;
use App\Http\Controllers\Admin\TemuDokterController as AdminTemuDokterController;
use App\Http\Controllers\Admin\RekamMedisController as AdminRekamMedisController;
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;
use App\Http\Controllers\Resepsionis\PemilikResepsionisController;
use App\Http\Controllers\Resepsionis\PetResepsionisController;
use App\Http\Controllers\Resepsionis\TemuDokterController;
use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Dokter\DetailRekamMedisController;
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Perawat\AntrianController;
use App\Http\Controllers\Perawat\PasienController;
use App\Http\Controllers\Perawat\RekamMedisController;
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
    Route::resource('dokter', DokterController::class); 
    Route::resource('perawat', PerawatController::class);
    Route::resource('pemilik', PemilikController::class);
    Route::resource('pet', PetController::class);
     Route::resource('temu-dokter', AdminTemuDokterController::class, ['parameters' => ['temu-dokter' => 'temuDokter']])->except(['show']);
     Route::resource('rekam-medis', AdminRekamMedisController::class, ['parameters' => ['rekam-medis' => 'rekamMedis']])->except(['show']);
});

// Resepsionis routes - Grouped with isResepsionis middleware
Route::prefix('resepsionis')->middleware(['auth', 'isResepsionis'])->name('resepsionis.')->group(function () {
     // Redirect base to dashboard
     Route::get('/', function () { return redirect()->route('resepsionis.dashboard'); });
    
    // Rute untuk halaman dashboard utama (yang ada kartu)
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])
         ->name('dashboard');

    // Rute resource untuk Temu Dokter (reservasi)
    Route::resource('temu-dokter', TemuDokterController::class)
         ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

    // Rute resource untuk Pemilik
    Route::resource('pemilik', PemilikResepsionisController::class)
         ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    
    // Rute resource untuk Pet
    Route::resource('pet', PetResepsionisController::class)
         ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
});

// Dokter routes - Grouped with isDokter middleware
Route::prefix('dokter')->middleware(['auth', 'isDokter'])->name('dokter.')->group(function () {
    // Redirect base to dashboard
    Route::get('/', function () { return redirect()->route('dokter.dashboard'); });

    Route::get('/dashboard', [DashboardDokterController::class, 'index'])
         ->name('dashboard');
    Route::get('/pasien/{pet}/rekam-medis', [DashboardDokterController::class, 'showRekamMedis'])
         ->name('rekam_medis.index');

    // Profil Dokter
    Route::get('/profil', [\App\Http\Controllers\Dokter\ProfileDokterController::class, 'show'])->name('profil.show');
     Route::get('/profil/edit', [\App\Http\Controllers\Dokter\ProfileDokterController::class, 'edit'])->name('profil.edit');
     Route::put('/profil', [\App\Http\Controllers\Dokter\ProfileDokterController::class, 'update'])->name('profil.update');

    // Detail Rekam Medis CRUD
    Route::resource('detail-rekam-medis', DetailRekamMedisController::class)
         ->only(['index', 'show']);
    Route::post('/rekam-medis/{rekamMedis}/detail', [DetailRekamMedisController::class, 'store'])
         ->name('detail_rekam_medis.store');
    Route::get('/rekam-medis/{rekamMedis}/detail/create', [DetailRekamMedisController::class, 'create'])
         ->name('detail_rekam_medis.create');
    Route::get('/detail-rekam-medis/{detailRekamMedis}/edit', [DetailRekamMedisController::class, 'edit'])
         ->name('detail_rekam_medis.edit');
    Route::put('/detail-rekam-medis/{detailRekamMedis}', [DetailRekamMedisController::class, 'update'])
         ->name('detail_rekam_medis.update');
    Route::delete('/detail-rekam-medis/{detailRekamMedis}', [DetailRekamMedisController::class, 'destroy'])
         ->name('detail_rekam_medis.destroy');
});

// Perawat routes - Grouped with isPerawat middleware
Route::prefix('perawat')->middleware(['auth', 'isPerawat'])->name('perawat.')->group(function () {
    // Redirect base to dashboard
    Route::get('/', function () { return redirect()->route('perawat.dashboard'); });

    // Rute untuk halaman dashboard utama (dengan kartu)
    Route::get('/dashboard', [DashboardPerawatController::class, 'index'])
         ->name('dashboard');

    // Rute untuk Temu Dokter Hari Ini
    Route::get('/temu-dokter/hari-ini', [\App\Http\Controllers\Perawat\TemuDokterController::class, 'hariIni'])->name('temu_dokter.hari_ini');

    // Rute untuk "Daftar Semua Temu Dokter"
    Route::get('/antrian', [AntrianController::class, 'index'])
         ->name('antrian.index');

    // Rute untuk "Daftar Semua Pasien" (untuk melihat rekam medis)
    Route::get('/pasien', [PasienController::class, 'index'])
         ->name('pasien.index');

    // Rute untuk "Detail Rekam Medis" per pasien
    Route::get('/pasien/{pet}', [PasienController::class, 'show'])
         ->name('pasien.show');

    // Rekam Medis CRUD
     Route::resource('rekam-medis', RekamMedisController::class, [
          'parameters' => ['rekam-medis' => 'rekam_medis']
     ])->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

    // Profil Perawat
    Route::get('/profil', [\App\Http\Controllers\Perawat\ProfileController::class, 'show'])->name('profil.show');

     // Detail Rekam Medis CRUD (khusus perawat)
          Route::resource('detail_rekam_medis', \App\Http\Controllers\Dokter\DetailRekamMedisController::class, [
               'as' => 'detail_rekam_medis'
          ])->only(['index', 'show', 'edit', 'update', 'destroy', 'create', 'store']);

          // Route khusus create detail rekam medis agar tidak error route not defined
          Route::get('/rekam-medis/{rekamMedis}/detail/create', [
              \App\Http\Controllers\Dokter\DetailRekamMedisController::class, 'create'])
              ->name('perawat.detail_rekam_medis.create');
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

    // Rute untuk halaman profil pemilik
    Route::get('/profil', [DashboardPemilikController::class, 'profil'])->name('profil');

    // Rute untuk edit profil pemilik
    Route::get('/profil/edit', [DashboardPemilikController::class, 'editProfil'])->name('profil.edit');
});