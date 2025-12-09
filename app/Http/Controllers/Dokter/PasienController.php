<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Menampilkan daftar semua pasien (pet).
     */
    public function index()
    {
        $semuaPasien = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])
                    ->orderBy('nama', 'asc')
                    ->get();

        // Blade expects `$pasiens` — provide it as an alias for compatibility.
        return view('dokter.pasien.index', [
            'pasiens' => $semuaPasien,
        ]);
    }

    /**
     * Menampilkan detail dan riwayat rekam medis satu pasien.
     */
    public function show(Pet $pet)
    {
        $riwayatMedis = RekamMedis::whereHas('temuDokter', function ($query) use ($pet) {
            $query->where('idpet', $pet->idpet);
        })
        ->with([
            'dokterPemeriksa.user',
            'detailRekamMedis.tindakanTerapi'
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('dokter.pasien.show', [
            'pasien' => $pet,
            'riwayat' => $riwayatMedis
        ]);
    }
}