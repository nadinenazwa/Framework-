<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perawat;
use App\Models\User;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    public function index()
    {
        $data = Perawat::with('user')->get();
        return view('admin.perawat.index', compact('data'));
    }

    public function create()
    {
        // Ambil semua user
        $users = User::all();
        return view('admin.perawat.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'iduser' => 'required|unique:perawat,iduser',
            'pendidikan' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        Perawat::create($request->all());

        return redirect()->route('admin.perawat.index')->with('success', 'Data Perawat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $perawat = Perawat::findOrFail($id);
        return view('admin.perawat.edit', compact('perawat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pendidikan' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        $perawat = Perawat::findOrFail($id);
        $perawat->update($request->except(['iduser']));

        return redirect()->route('admin.perawat.index')->with('success', 'Data Perawat berhasil diperbarui');
    }

    public function destroy($id)
    {
        $perawat = Perawat::findOrFail($id);
        $perawat->delete();

        return redirect()->route('admin.perawat.index')->with('success', 'Data Perawat berhasil dihapus');
    }
}