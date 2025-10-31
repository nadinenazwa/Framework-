<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Kita tidak perlu 'use App\Models\TemuDokter;' lagi di sini

class DashboardResepsionisController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama (dengan kartu).
     */
    public function index()
    {
        // Sekarang controller ini HANYA menampilkan view dashboard
        return view('resepsionis.dashboard');
    }
}