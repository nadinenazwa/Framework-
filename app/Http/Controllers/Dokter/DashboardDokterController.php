<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pet; // Model Pasien
use App\Models\RekamMedis; // Model Rekam Medis
use App\Models\DetailRekamMedis; // Model Detail Rekam Medis
use App\Models\TemuDokter;
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

        // 2. Ambil daftar kunjungan terbaru untuk dokter ini (termasuk reservasi)
        $latestVisits = TemuDokter::with('pet.pemilik.user', 'roleUser.user')
            ->where('idrole_user', $dokterRole->idrole_user)
            ->orderBy('waktu_daftar', 'desc')
            ->take(10)
            ->get();

        // Untuk tampilan pasien terbaru, ambil pet unik dari kunjungan terakhir
        $latestPatients = $latestVisits->map(function ($visit) {
            $pet = $visit->pet;
            if ($pet) {
                $pet->last_visit = $visit->waktu_daftar;
            }
            return $pet;
        })->filter()->unique('idpet')->values()->take(10);

        // 3. Hitung pemeriksaan yang belum selesai untuk dokter ini (status pending)
        // dan ambil daftar kunjungan yang benar-benar memiliki status '1'.
        // Kita paksa pengecekan ketat terhadap nilai '1' agar hanya menampilkan
        // rekaman yang benar-benar menunggu.
        $pendingCount = TemuDokter::where('idrole_user', $dokterRole->idrole_user)
            ->where('status', '1')
            ->count();

        // 4. Ambil detail kunjungan yang berstatus pending ('1') untuk ditampilkan
        // di dashboard (paling baru dulu, batasi 10).
        $pendingVisits = TemuDokter::with('pet.pemilik.user', 'roleUser.user', 'rekamMedis')
            ->where('idrole_user', $dokterRole->idrole_user)
            ->where('status', '1')
            ->orderBy('waktu_daftar', 'desc')
            ->take(10)
            ->get();

        // 3. Hitung total pasien (unik)
        $totalPatients = Pet::whereHas('temuDokter', function ($query) use ($dokterRole) {
            $query->where('idrole_user', $dokterRole->idrole_user);
        })->distinct()->count('idpet');

        // 4. Hitung total detail rekam medis yang dibuat untuk pasien yang ditangani dokter ini
        $totalDetailRekam = DetailRekamMedis::whereHas('rekamMedis', function ($q) use ($dokterRole) {
            $q->whereHas('temuDokter', function ($q2) use ($dokterRole) {
                $q2->where('idrole_user', $dokterRole->idrole_user);
            });
        })->count();

        // 5. Tampilkan view dengan data terbaru
        return view('dokter.dashboard', [
            'pasiens' => $latestPatients,
            'latestVisits' => $latestVisits,
            'pendingVisits' => $pendingVisits,
            'pendingCount' => $pendingCount,
            'totalPatients' => $totalPatients,
            'totalMedicalRecords' => RekamMedis::whereHas('temuDokter', function ($q) use ($dokterRole) {
                $q->where('idrole_user', $dokterRole->idrole_user);
            })->count(),
            'totalDetailRekam' => $totalDetailRekam,
        ]);
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