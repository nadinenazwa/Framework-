<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Pemilik;
use App\Models\Pet;
use App\Models\TemuDokter;

class DashboardResepsionisController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama (dengan kartu).
     */
    public function index()
    {
        $totalPemilik = Pemilik::count();
        $totalPet = Pet::count();
        $totalTemuDokter = TemuDokter::count();
        return view('resepsionis.dashboard', compact('totalPemilik', 'totalPet', 'totalTemuDokter'));
    }
}