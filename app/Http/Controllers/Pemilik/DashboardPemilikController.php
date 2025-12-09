<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RekamMedis;
use App\Models\TemuDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Penting untuk otentikasi

class DashboardPemilikController extends Controller
{
    /**
     * Menampilkan daftar pet milik pemilik yang sedang login.
     */
    public function index()
    {
        // 1. Dapatkan data 'pemilik' yang terhubung dengan user yang login
        $pemilik = Auth::user()->pemilik;

        // 2. Ambil semua pet yang 'idpemilik'-nya cocok
        // Kita juga load relasi 'rasHewan' dan 'jenisHewan'
        $pets = Pet::where('idpemilik', $pemilik->idpemilik)
                    ->with(['rasHewan.jenisHewan'])
                    ->get();

        // totals and recent items for dashboard cards
        $totalPets = $pets->count();

        $petIds = $pets->pluck('idpet')->toArray();

        $upcomingAppointments = TemuDokter::with(['pet', 'roleUser.user'])
            ->whereIn('idpet', $petIds)
            ->orderBy('waktu_daftar', 'asc')
            ->take(10)
            ->get();

        $recentRekams = RekamMedis::whereHas('temuDokter', function ($q) use ($petIds) {
                $q->whereIn('idpet', $petIds);
            })
            ->with(['dokterPemeriksa.user', 'temuDokter.pet'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Tampilkan view dashboard pemilik
        return view('pemilik.dashboard', compact('pets', 'totalPets', 'upcomingAppointments', 'recentRekams'));
    }

    /**
     * Menampilkan riwayat rekam medis dari satu pet.
     */
    public function showRekamMedis(Pet $pet)
    {
        // 1. Dapatkan 'idpemilik' dari user yang sedang login
        $idPemilikAuth = Auth::user()->pemilik->idpemilik;

        // 2. 🚨 CEK KEAMANAN 🚨
        // Pastikan pet yang diminta adalah milik pemilik yang login.
        // Jika tidak, hentikan dan tampilkan error 403 (Forbidden).
        if ($pet->idpemilik != $idPemilikAuth) {
            abort(403, 'Akses Ditolak');
        }

        // 3. Jika aman, ambil riwayat medis
        // Logika ini sama persis dengan yang dipakai Dokter & Perawat
        $riwayatMedis = RekamMedis::whereHas('temuDokter', function ($query) use ($pet) {
            $query->where('idpet', $pet->idpet);
        })
        ->with([
            'dokterPemeriksa.user',
            'detailRekamMedis.tindakanTerapi'
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        
        // 4. Tampilkan view
        return view('pemilik.rekam-medis.show', [
            'pasien' => $pet, // Kirim data pet sebagai 'pasien'
            'riwayat' => $riwayatMedis
        ]);
    }

    /**
     * Show a single Rekam Medis detail to the owner (ensure ownership)
     */
    public function showRekamMedisDetail($rekamMedisId)
    {
        $user = Auth::user();
        $pemilik = $user->pemilik;
        if (! $pemilik) {
            abort(404, 'Pemilik tidak ditemukan');
        }

        $rekam = RekamMedis::with(['temuDokter.pet.rasHewan', 'detailRekamMedis.tindakanTerapi', 'dokterPemeriksa.user'])
            ->where('idrekam_medis', $rekamMedisId)
            ->firstOrFail();

        // verify ownership: temuDokter -> pet -> idpemilik must match
        $pet = $rekam->temuDokter ? $rekam->temuDokter->pet : null;
        if (! $pet || $pet->idpemilik != $pemilik->idpemilik) {
            abort(403, 'Akses Ditolak');
        }

        return view('pemilik.rekam-medis.show', [
            'pasien' => $pet,
            'riwayat' => collect([$rekam]),
            'rekamMedis' => $rekam,
        ]);
    }

    /**
     * Menampilkan halaman profil pemilik.
     */
    public function profil()
    {
        return view('pemilik.profile.index');
    }

    /**
     * Menampilkan halaman edit profil pemilik.
     */
    public function editProfil()
    {
        $pemilik = Auth::user()->pemilik;
        return view('pemilik.profile.edit', compact('pemilik'));
    }
}