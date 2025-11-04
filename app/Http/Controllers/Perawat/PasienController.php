<?php

namespace App\Http\Controllers\Perawat;

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
                    
        return view('perawat.pasien.index', compact('semuaPasien'));
    }

    /**
     * Menampilkan detail dan riwayat rekam medis satu pasien.
     */
    public function show(Pet $pet)
    {
        // Logika ini sama persis dengan yang dipakai Dokter
        $riwayatMedis = RekamMedis::whereHas('temuDokter', function ($query) use ($pet) {
            $query->where('idpet', $pet->idpet);
        })
        ->with([
            'dokterPemeriksa.user', // Nama dokter
            'detailRekamMedis.tindakanTerapi' // Detail tindakan
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        
        // Tampilkan view detail rekam medis
        return view('perawat.pasien.show', [
            'pasien' => $pet,
            'riwayat' => $riwayatMedis
        ]);
    }
}