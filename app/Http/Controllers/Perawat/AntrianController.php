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
        // Pastikan juga memuat relasi `rekamMedis` sehingga view dapat
        // menentukan apakah tombol "Tambah Rekam" harus ditampilkan.
        // Load rekamMedis (only non-deleted) so soft-deleted records are
        // not shown in the UI.
        $semuaKunjungan = TemuDokter::with(['pet.pemilik.user', 'roleUser.user', 'rekamMedis'])
            // count soft-deleted rekam_medis so the UI can show an indicator
            ->withCount(['rekamMedis as rekam_trashed_count' => function ($q) { $q->onlyTrashed(); }])
            ->orderBy('waktu_daftar', 'desc') // Tampilkan yang terbaru di atas
            ->get();
            
        return view('perawat.antrian.index', compact('semuaKunjungan'));
    }
}