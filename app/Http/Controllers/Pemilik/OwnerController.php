<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pet;
use App\Models\TemuDokter;
use App\Models\RekamMedis;

class OwnerController extends Controller
{
    /**
     * Show current owner's profile and pets
     */
    public function profile()
    {
        $user = Auth::user();
        $pemilik = $user->pemilik;

        $pets = [];
        if ($pemilik) {
            $pets = Pet::where('idpemilik', $pemilik->idpemilik)
                ->with(['rasHewan'])
                ->get();
        }

        return view('pemilik.profile.index', [
            'user' => $user,
            'pemilik' => $pemilik,
            'pets' => $pets,
        ]);
    }

    /**
     * Update profile information for the logged-in owner (name, email, password)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . ($user->iduser ?? 'NULL') . ',iduser',
            'password' => 'nullable|string|min:6|confirmed',
            'no_wa' => 'nullable|string|max:30',
            'alamat' => 'nullable|string|max:1000',
        ]);

        // Update user fields
        $user->nama = $data['nama'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Update pemilik fields if the relationship exists
        $pemilik = $user->pemilik;
        if ($pemilik) {
            $pemilik->no_wa = $data['no_wa'] ?? $pemilik->no_wa;
            $pemilik->alamat = $data['alamat'] ?? $pemilik->alamat;
            $pemilik->save();
        }

        return redirect()->route('pemilik.profile')->with('success', 'Profil diperbarui');
    }

    /**
     * List appointments (temu dokter) for the logged-in owner's pets
     */
    public function appointments(Request $request)
    {
        $user = Auth::user();
        $pemilik = $user->pemilik;
        if (! $pemilik) {
            abort(404, 'Pemilik tidak ditemukan');
        }

        $perPage = $request->get('per_page', 15);
        $appointments = TemuDokter::whereHas('pet', function ($q) use ($pemilik) {
            $q->where('idpemilik', $pemilik->idpemilik);
        })->with(['pet.rasHewan', 'roleUser.user'])->orderBy('idreservasi_dokter', 'desc')->paginate($perPage);

        return view('pemilik.appointments.index', ['appointments' => $appointments]);
    }

    /**
     * Show medical records for all pets belonging to the logged-in owner
     */
    public function medicalRecords(Request $request)
    {
        $user = Auth::user();
        $pemilik = $user->pemilik;
        if (! $pemilik) {
            abort(404, 'Pemilik tidak ditemukan');
        }

        // Eager-load rekam medis for each pet via temuDokter relationship
        $pets = Pet::where('idpemilik', $pemilik->idpemilik)
            ->with(['temuDokter.rekamMedis.dokterPemeriksa.user', 'rasHewan'])
            ->get();

        return view('pemilik.rekam-medis.index', ['pets' => $pets]);
    }
}
