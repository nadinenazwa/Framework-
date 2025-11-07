<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KategoriKlinis;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class KategoriKlinisController extends Controller
{
    public function index()
    {
        $kategoriKlinis = KategoriKlinis::all();
        return view('admin.KategoriKlinis.index', compact('kategoriKlinis'));
    }

    public function create()
    {
        return view('admin.KategoriKlinis.create');
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

            return redirect()->route('admin.kategoriklinis.index')
                ->with('success', 'Data kategori klinis berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data kategori klinis: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kategoriKlinis = KategoriKlinis::findOrFail($id);
        return view('admin.KategoriKlinis.edit', compact('kategoriKlinis'));
    }

    public function update(Request $request, $id)
    {
        $kategoriKlinis = KategoriKlinis::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kategoriKlinis->update([
                'nama_kategori_klinis' => $this->formatNama($request->nama_kategori_klinis),
            ]);

            return redirect()->route('admin.kategoriklinis.index')
                ->with('success', 'Data kategori klinis berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data kategori klinis: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kategoriKlinis = KategoriKlinis::findOrFail($id);
            $kategoriKlinis->delete();

            return redirect()->route('admin.kategoriklinis.index')
                ->with('success', 'Data kategori klinis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data kategori klinis: ' . $e->getMessage());
        }
    }

    /**
     * Validate kategori klinis data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'nama_kategori_klinis' => 'required|string|max:255|unique:kategori_klinis,nama_kategori_klinis' . ($id ? ',' . $id . ',idkategori_klinis' : ''),
        ];

        $messages = [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.string' => 'Nama kategori klinis harus berupa teks.',
            'nama_kategori_klinis.max' => 'Nama kategori klinis maksimal 255 karakter.',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis sudah ada.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new kategori klinis record
     */
    private function createRecord(Request $request)
    {
        return KategoriKlinis::create([
            'nama_kategori_klinis' => $this->formatNama($request->nama_kategori_klinis),
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
