<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.Kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.Kategori.create');
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

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Data kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data kategori: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.Kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kategori->update([
                'nama_kategori' => $this->formatNama($request->nama_kategori),
            ]);

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Data kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data kategori: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return redirect()->route('admin.kategori.index')
                ->with('success', 'Data kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data kategori: ' . $e->getMessage());
        }
    }

    /**
     * Validate kategori data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori' . ($id ? ',' . $id . ',idkategori' : ''),
        ];

        $messages = [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new kategori record
     */
    private function createRecord(Request $request)
    {
        return Kategori::create([
            'nama_kategori' => $this->formatNama($request->nama_kategori),
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
