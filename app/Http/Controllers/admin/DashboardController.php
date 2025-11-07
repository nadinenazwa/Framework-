<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\Role;
use Illuminate\Http\Request;
use illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for admin dashboard
        $totalUsers = User::count();
        $totalPets = Pet::count();
        $totalOwners = Pemilik::count();
        $totalRoles = Role::count();

        // Recent pets
        $recentPets = Pet::with(['pemilik.user', 'rasHewan'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPets',
            'totalOwners',
            'totalRoles',
            'recentPets'
        ));
    }
}
