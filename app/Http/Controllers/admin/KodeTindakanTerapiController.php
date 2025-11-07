<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        $kodeTindakanTerapi = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();
        return view('admin.KodeTindakanTerapi.index', compact('kodeTindakanTerapi'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.create', compact('kategori', 'kategoriKlinis'));
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

            return redirect()->route('admin.kodetindakanterapi.index')
                ->with('success', 'Data kode tindakan terapi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data kode tindakan terapi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kodeTindakanTerapi = KodeTindakanTerapi::findOrFail($id);
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();
        return view('admin.KodeTindakanTerapi.edit', compact('kodeTindakanTerapi', 'kategori', 'kategoriKlinis'));
    }

    public function update(Request $request, $id)
    {
        $kodeTindakanTerapi = KodeTindakanTerapi::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kodeTindakanTerapi->update([
                'kode' => strtoupper(trim($request->kode)),
                'deskripsi_tindakan_terapi' => ucfirst(trim($request->deskripsi_tindakan_terapi)),
                'idkategori' => $request->idkategori,
                'idkategori_klinis' => $request->idkategori_klinis,
            ]);

            return redirect()->route('admin.kodetindakanterapi.index')
                ->with('success', 'Data kode tindakan terapi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data kode tindakan terapi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kodeTindakanTerapi = KodeTindakanTerapi::findOrFail($id);
            $kodeTindakanTerapi->delete();

            return redirect()->route('admin.kodetindakanterapi.index')
                ->with('success', 'Data kode tindakan terapi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data kode tindakan terapi: ' . $e->getMessage());
        }
    }

    /**
     * Validate kode tindakan terapi data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'kode' => 'required|string|max:50|unique:kode_tindakan_terapi,kode' . ($id ? ',' . $id . ',idkode_tindakan_terapi' : ''),
            'deskripsi_tindakan_terapi' => 'required|string',
            'idkategori' => 'required|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|exists:kategori_klinis,idkategori_klinis',
        ];

        $messages = [
            'kode.required' => 'Kode tindakan wajib diisi.',
            'kode.string' => 'Kode tindakan harus berupa teks.',
            'kode.max' => 'Kode tindakan maksimal 50 karakter.',
            'kode.unique' => 'Kode tindakan sudah ada.',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi tindakan terapi wajib diisi.',
            'deskripsi_tindakan_terapi.string' => 'Deskripsi tindakan terapi harus berupa teks.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori.exists' => 'Kategori tidak valid.',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih.',
            'idkategori_klinis.exists' => 'Kategori klinis tidak valid.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new kode tindakan terapi record
     */
    private function createRecord(Request $request)
    {
        return KodeTindakanTerapi::create([
            'kode' => strtoupper(trim($request->kode)),
            'deskripsi_tindakan_terapi' => ucfirst(trim($request->deskripsi_tindakan_terapi)),
            'idkategori' => $request->idkategori,
            'idkategori_klinis' => $request->idkategori_klinis,
        ]);
    }

    /**
     * Format nama with proper capitalization (not used in this controller)
     */
    private function formatNama($nama)
    {
        return ucwords(strtolower(trim($nama)));
    }
}
