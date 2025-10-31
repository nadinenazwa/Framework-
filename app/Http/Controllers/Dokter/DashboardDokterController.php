<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pet; // Model Pasien
use App\Models\RekamMedis; // Model Rekam Medis
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan data dokter yang login

class DashboardDokterController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard dokter (Daftar Pasien).
     */
    public function index()
    {
        // 1. Dapatkan data dokter (role_user) yang sedang login
        // Asumsi: idrole=2 adalah Dokter
        $dokterRole = Auth::user()->roleUser()->where('idrole', 2)->firstOrFail();

        // 2. Ambil daftar pasien unik yang pernah ditangani oleh dokter ini.
        // Kita menggunakan relasi 'whereHas' untuk memfilter Pet
        // yang memiliki 'temuDokter' yang ditangani oleh 'idrole_user' dokter ini.
        $pasiens = Pet::whereHas('temuDokter', function ($query) use ($dokterRole) {
            $query->where('idrole_user', $dokterRole->idrole_user);
        })
        ->with(['pemilik.user', 'rasHewan.jenisHewan']) // Eager loading untuk data terkait
        ->distinct() // Hanya pasien unik
        ->get();

        // 3. Tampilkan view dengan data pasien
        return view('dokter.dashboard', compact('pasiens'));
    }

    /**
     * Menampilkan riwayat rekam medis untuk satu pasien.
     */
    public function showRekamMedis(Pet $pet)
    {
        // 1. Ambil semua rekam medis untuk pasien ini ($pet didapat dari route-model binding)
        // Kita cari RekamMedis yang relasi 'temuDokter'-nya memiliki idpet dari $pet
        $riwayatMedis = RekamMedis::whereHas('temuDokter', function ($query) use ($pet) {
            $query->where('idpet', $pet->idpet);
        })
        ->with([
            'dokterPemeriksa.user', // Nama dokter yang memeriksa
            'detailRekamMedis.tindakanTerapi' // Detail tindakan
        ])
        ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
        ->get();

        // 2. Tampilkan view detail dengan data pasien dan riwayatnya
        return view('dokter.rekam_medis.index', [
            'pasien' => $pet,
            'riwayat' => $riwayatMedis
        ]);
    }
}