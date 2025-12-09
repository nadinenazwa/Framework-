<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $perawat = $user->perawat; // pastikan relasi user->perawat ada
        return view('perawat.profil.show', compact('user', 'perawat'));
    }

    public function edit()
    {
        $user = Auth::user();
        $perawat = $user->perawat;
        return view('perawat.profil.edit', compact('user', 'perawat'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $perawat = $user->perawat;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:1000',
            'tanggal_lahir' => 'nullable|date',
        ]);

        // Update user
        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        $user->save();

        // Update perawat (create if not exists)
        if (!$perawat) {
            $perawat = $user->perawat()->create([]);
        }

        $perawat->no_telp = $validated['no_telp'] ?? $perawat->no_telp;
        $perawat->alamat = $validated['alamat'] ?? $perawat->alamat;
        if (!empty($validated['tanggal_lahir'])) {
            $perawat->tanggal_lahir = $validated['tanggal_lahir'];
        }
        $perawat->save();

        return redirect()->route('perawat.profil.show')
            ->with('success', 'Profil perawat berhasil diperbarui.');
    }
}
