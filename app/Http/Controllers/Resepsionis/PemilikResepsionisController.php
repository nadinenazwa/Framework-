<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik;

class PemilikResepsionisController extends Controller
{
    public function index()
    {
        $pemilik = Pemilik::with('user')->get();
        return view('resepsionis.pemilik.index', compact('pemilik'));
    }
}