<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPerawatController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama Perawat (dengan kartu).
     */
    public function index()
    {
        return view('perawat.dashboard');
    }
}