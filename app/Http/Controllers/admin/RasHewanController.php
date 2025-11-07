<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RasHewan;
use App\Models\JenisHewan;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class RasHewanController extends Controller
{
    public function index()
    {
        $rasHewan = RasHewan::with('jenisHewan')->get();
        return view('admin.RasHewan.index', compact('rasHewan'));
    }

    public function create()
    {
        $jenisHewan = JenisHewan::all();
        return view('admin.RasHewan.create', compact('jenisHewan'));
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

            return redirect()->route('admin.rashewan.index')
                ->with('success', 'Data ras hewan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data ras hewan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $rasHewan = RasHewan::findOrFail($id);
        $jenisHewan = JenisHewan::all();
        return view('admin.RasHewan.edit', compact('rasHewan', 'jenisHewan'));
    }

    public function update(Request $request, $id)
    {
        $rasHewan = RasHewan::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $rasHewan->update([
                'nama_ras' => $this->formatNama($request->nama_ras),
                'idjenis_hewan' => $request->idjenis_hewan,
            ]);

            return redirect()->route('admin.rashewan.index')
                ->with('success', 'Data ras hewan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data ras hewan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $rasHewan = RasHewan::findOrFail($id);
            $rasHewan->delete();

            return redirect()->route('admin.rashewan.index')
                ->with('success', 'Data ras hewan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data ras hewan: ' . $e->getMessage());
        }
    }

    /**
     * Validate ras hewan data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'nama_ras' => 'required|string|max:255',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ];

        $messages = [
            'nama_ras.required' => 'Nama ras wajib diisi.',
            'nama_ras.string' => 'Nama ras harus berupa teks.',
            'nama_ras.max' => 'Nama ras maksimal 255 karakter.',
            'idjenis_hewan.required' => 'Jenis hewan wajib dipilih.',
            'idjenis_hewan.exists' => 'Jenis hewan tidak valid.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new ras hewan record
     */
    private function createRecord(Request $request)
    {
        return RasHewan::create([
            'nama_ras' => $this->formatNama($request->nama_ras),
            'idjenis_hewan' => $request->idjenis_hewan,
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
