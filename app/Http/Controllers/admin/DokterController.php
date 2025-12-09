<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        // Eager load relasi user untuk performa
        $data = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('data'));
    }

    public function create()
    {
        // Ambil semua user untuk dropdown
        // Opsional: Filter hanya user yang punya role 'Dokter' tapi belum ada di tabel dokter
        // $users = User::whereDoesntHave('dokter')->get(); 
        $users = User::all(); 
        return view('admin.dokter.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'iduser' => 'required|unique:dokter,iduser',
            'bidang_dokter' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        Dokter::create($request->all());

        return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter berhasil ditambahkan');
    }

    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bidang_dokter' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $dokter = Dokter::findOrFail($id);
        
        // iduser biasanya tidak diubah di edit profil, jadi kita exclude atau update hati-hati
        $dokter->update($request->except(['iduser']));

        return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter berhasil diperbarui');
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();

        return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter berhasil dihapus');
    }

    public function viewDataPasien()
    {
        // Logic to fetch data pasien
        $dataPasien = User::where('role', 'pasien')->get();
        return view('dokter.data_pasien', compact('dataPasien'));
    }

    public function viewRekamMedis()
    {
        // Logic to fetch rekam medis
        $rekamMedis = RekamMedis::with(['dokter', 'pasien'])->get();
        return view('dokter.rekam_medis', compact('rekamMedis'));
    }

    public function crudDetailRekamMedis()
    {
        // Admin controller should not return dokter.* views. Use Dokter\DetailRekamMedisController for dokter role.
        // This method intentionally left blank to avoid accidental view routing.
    }
}