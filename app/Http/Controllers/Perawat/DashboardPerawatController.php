<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TemuDokter;
use App\Models\Pet;

class DashboardPerawatController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama Perawat (dengan kartu).
     */
    public function index()
    {
        // compute basic metrics for the perawat dashboard
        $totalAntrian = TemuDokter::count();
        $totalSelesai = TemuDokter::where('status', '2')->count();
        $totalMenunggu = TemuDokter::where('status', '1')->count();
        $totalPasien = Pet::count();

        $recentAppointments = TemuDokter::with('pet', 'roleUser.user')
            ->orderBy('waktu_daftar', 'desc')
            ->limit(6)
            ->get();

        return view('perawat.dashboard', compact(
            'totalAntrian', 'totalSelesai', 'totalMenunggu', 'totalPasien', 'recentAppointments'
        ));
    }
}