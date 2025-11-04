<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    /**
     * Menampilkan daftar semua kunjungan (temu dokter).
     */
    public function index()
    {
        // Ambil SEMUA data temu_dokter, urutkan dari yang terbaru
        $semuaKunjungan = TemuDokter::with(['pet.pemilik.user', 'roleUser.user'])
            ->orderBy('waktu_daftar', 'desc') // Tampilkan yang terbaru di atas
            ->get();
            
        return view('perawat.antrian.index', compact('semuaKunjungan'));
    }
}