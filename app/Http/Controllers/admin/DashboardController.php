<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\Role;
use Illuminate\Http\Request;
use illuminate\Support\Facades\DB;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\RekamMedis;
use App\Models\TemuDokter;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for admin dashboard
        $totalUsers = User::count();
        $totalPets = Pet::count();
        $totalOwners = Pemilik::count();
        $totalRoles = Role::count();
        $totalDoctors = Dokter::count();
        $totalNurses = Perawat::count();
        $totalAppointments = TemuDokter::count();
        $totalMedicalRecords = RekamMedis::count();

        // Recent users - order by iduser descending (latest added)
        $recentUsers = User::with('roles')
            ->orderBy('iduser', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPets',
            'totalOwners',
            'totalRoles',
            'recentUsers',
            'totalDoctors',
            'totalNurses',
            'totalAppointments',
            'totalMedicalRecords'
        ));
    }
}
