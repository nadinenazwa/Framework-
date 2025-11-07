<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pemilik;
use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class PemilikController extends Controller
{
    public function index()
    {
        $pemilik = Pemilik::with('user')->get();
        return view('admin.Pemilik.index', compact('pemilik'));
    }

    public function create()
    {
        $users = User::whereHas('roles', function($query) {
            $query->where('nama_role', 'pemilik');
        })->get();
        return view('admin.Pemilik.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = $this->validateData($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->createRecord($request);

            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Data pemilik berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data pemilik: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pemilik = Pemilik::with('user')->findOrFail($id);
        $users = User::whereHas('roles', function($query) {
            $query->where('nama_role', 'pemilik');
        })->get();
        return view('admin.Pemilik.edit', compact('pemilik', 'users'));
    }

    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pemilik->update([
                'iduser' => $request->iduser,
                'no_wa' => trim($request->no_wa),
                'alamat' => ucfirst(trim($request->alamat)),
            ]);

            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Data pemilik berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data pemilik: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pemilik = Pemilik::findOrFail($id);
            $pemilik->delete();

            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Data pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Validate pemilik data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'iduser' => 'required|exists:user,iduser|unique:pemilik,iduser' . ($id ? ',' . $id . ',idpemilik' : ''),
            'no_wa' => 'required|string|max:20',
            'alamat' => 'required|string',
        ];

        $messages = [
            'iduser.required' => 'User wajib dipilih.',
            'iduser.exists' => 'User tidak valid.',
            'iduser.unique' => 'User sudah terdaftar sebagai pemilik.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 20 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new pemilik record
     */
    private function createRecord(Request $request)
    {
        return Pemilik::create([
            'iduser' => $request->iduser,
            'no_wa' => trim($request->no_wa),
            'alamat' => ucfirst(trim($request->alamat)),
        ]);
    }

    /**
     * Format nama with proper capitalization
     */
    private function formatNama($nama)
    {
        return ucwords(strtolower(trim($nama)));
    }
}
