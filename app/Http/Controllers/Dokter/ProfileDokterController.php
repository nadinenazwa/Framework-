<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileDokterController extends Controller
{
    public function show()
    {
        $dokter = Auth::user()->dokter; // relasi user->dokter
        return view('dokter.profil.show', compact('dokter'));
    }

    public function edit()
    {
        $dokter = Auth::user()->dokter;
        return view('dokter.profil.edit', compact('dokter'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $dokter = $user->dokter;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'bidang_dokter' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->save();

        $dokter->bidang_dokter = $request->bidang_dokter;
        $dokter->no_hp = $request->no_hp;
        $dokter->alamat = $request->alamat;
        $dokter->jenis_kelamin = $request->jenis_kelamin;
        $dokter->save();

        return redirect()->route('dokter.profil.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
