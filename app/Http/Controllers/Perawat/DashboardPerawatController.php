<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\KategoriKlinis;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;

class DashboardPerawatController extends Controller
{
    public function index()
    {
        // Get statistics for perawat dashboard
        $totalPets = Pet::count();
        $totalClinicalCategories = KategoriKlinis::count();
        $totalTherapyCodes = KodeTindakanTerapi::count();

        // Recent pets for monitoring
        $recentPets = Pet::with(['pemilik.user', 'rasHewan'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('perawat.dashboard', compact(
            'totalPets',
            'totalClinicalCategories',
            'totalTherapyCodes',
            'recentPets'
        ));
    }
}
