<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $perawat = $user->perawat; // pastikan relasi user->perawat ada
        return view('perawat.profil.show', compact('user', 'perawat'));
    }
}
