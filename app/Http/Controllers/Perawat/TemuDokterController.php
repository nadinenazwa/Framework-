<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use Illuminate\Http\Request;

class TemuDokterController extends Controller
{
    public function hariIni()
    {
        $today = now()->toDateString();
        $temuDokter = TemuDokter::with(['pet.pemilik.user', 'roleUser.user'])
            ->whereDate('waktu_daftar', $today)
            ->orderBy('waktu_daftar', 'asc')
            ->get();

        return view('perawat.temu_dokter.hari_ini', compact('temuDokter'));
    }
}
