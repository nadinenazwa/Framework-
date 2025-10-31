<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter; 
use Illuminate\Http\Request;

class TemuDokterController extends Controller
{
    public function index()
    {
        // Ambil data temu_dokter yang statusnya 'Menunggu' (asumsi status '1')
        $daftarTunggu = TemuDokter::with(['pet.pemilik.user', 'roleUser.user'])            ->where('status', '1') // Hanya tampilkan yang sedang menunggu
            ->orderBy('no_urut', 'asc')
            ->get();
            
        // Tampilkan view daftar tunggu
        return view('resepsionis.temu_dokter.index', compact('daftarTunggu'));
    }
}