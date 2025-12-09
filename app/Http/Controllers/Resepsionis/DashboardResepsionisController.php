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
        $recentAppointments = TemuDokter::with(['pet', 'roleUser.user.dokter'])->orderBy('waktu_daftar', 'desc')->take(10)->get();
        // Models don't have `created_at` timestamps enabled, so avoid `latest()` which orders by that column.
        // Order by primary key descending as a reasonable proxy for "recent" inserts.
        $recentPets = Pet::orderBy('idpet', 'desc')->take(10)->get();
        $recentOwners = Pemilik::orderBy('idpemilik', 'desc')->take(10)->get();
        return view('resepsionis.dashboard', compact('totalPemilik', 'totalPet', 'totalTemuDokter', 'recentAppointments', 'recentPets', 'recentOwners'));
    }
}