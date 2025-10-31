<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Pemilik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        // Get current user
        $user = Auth::user();

        // Get pemilik data for current user
        $pemilik = Pemilik::where('iduser', $user->iduser)->first();

        // Get statistics for pemilik dashboard
        $totalPets = $pemilik ? Pet::where('idpemilik', $pemilik->idpemilik)->count() : 0;

        // Get user's pets
        $userPets = $pemilik ? Pet::with(['rasHewan'])
            ->where('idpemilik', $pemilik->idpemilik)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get() : collect();

        return view('pemilik.dashboard', compact(
            'totalPets',
            'userPets',
            'pemilik'
        ));
    }
}
