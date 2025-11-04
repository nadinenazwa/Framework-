<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RekamMedis;
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
            
        // 3. Tampilkan view dashboard pemilik
        return view('pemilik.dashboard', compact('pets'));
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
        return view('pemilik.rekam_medis', [
            'pasien' => $pet, // Kirim data pet sebagai 'pasien'
            'riwayat' => $riwayatMedis
        ]);
    }
}