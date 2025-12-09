<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\User;
use Illuminate\Http\Request;

class PemilikResepsionisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pemilik = Pemilik::with('user', 'pet')->paginate(15);
            return view('resepsionis.pemilik.index', compact('pemilik'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            // Get users that don't have pemilik role yet (optional filter)
            return view('resepsionis.pemilik.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_pemilik' => 'required|string|max:150',
                'no_hp' => 'required|string|max:20|regex:/^(\+62|0)[0-9]{9,12}$/',
                'alamat' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'nama_pemilik.required' => 'Nama pemilik wajib diisi',
                'no_hp.required' => 'No. HP wajib diisi',
                'no_hp.regex' => 'No. HP harus format yang valid (diawali +62 atau 0)',
                'alamat.required' => 'Alamat wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai',
            ]);

            // Create user account
            $user = User::create([
                'name' => $validated['nama_pemilik'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            // Create pemilik record
            Pemilik::create([
                'nama_pemilik' => $validated['nama_pemilik'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
                'iduser' => $user->iduser,
            ]);

            return redirect()->route('resepsionis.pemilik.index')
                           ->with('success', 'Pemilik berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemilik $pemilik)
    {
        try {
            $pemilik->load(['user', 'pet.jenisHewan', 'pet.rasHewan']);
            return view('resepsionis.pemilik.show', compact('pemilik'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemilik $pemilik)
    {
        try {
            $pemilik->load('user');
            return view('resepsionis.pemilik.edit', compact('pemilik'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat form edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemilik $pemilik)
    {
        try {
            $validated = $request->validate([
                'nama_pemilik' => 'required|string|max:150',
                'no_hp' => 'required|string|max:20|regex:/^(\+62|0)[0-9]{9,12}$/',
                'alamat' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $pemilik->iduser . ',iduser',
            ], [
                'nama_pemilik.required' => 'Nama pemilik wajib diisi',
                'no_hp.required' => 'No. HP wajib diisi',
                'no_hp.regex' => 'No. HP harus format yang valid (diawali +62 atau 0)',
                'alamat.required' => 'Alamat wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
            ]);

            // Update pemilik
            $pemilik->update([
                'nama_pemilik' => $validated['nama_pemilik'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
            ]);

            // Update user email if changed
            if ($pemilik->user->email !== $validated['email']) {
                $pemilik->user->update(['email' => $validated['email']]);
            }

            return redirect()->route('resepsionis.pemilik.show', $pemilik->idpemilik)
                           ->with('success', 'Pemilik berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemilik $pemilik)
    {
        try {
            $pemilik->deleted_by = auth()->id();
            $pemilik->save();
            $pemilik->delete();

            return redirect()->route('resepsionis.pemilik.index')
                ->with('success', 'Pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pemilik: ' . $e->getMessage());
        }
    }
}