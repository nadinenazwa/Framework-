<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisHewan;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class JenisHewanController extends Controller
{
    public function index()
    {
        $jenisHewan = JenisHewan::all();
        return view('admin.JenisHewan.index', compact('jenisHewan'));
    }

    public function create()
    {
        return view('admin.JenisHewan.create');
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

            return redirect()->route('admin.jenish.index')
                ->with('success', 'Data jenis hewan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data jenis hewan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $jenisHewan = JenisHewan::findOrFail($id);
        return view('admin.JenisHewan.edit', compact('jenisHewan'));
    }

    public function update(Request $request, $id)
    {
        $jenisHewan = JenisHewan::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $jenisHewan->update([
                'nama_jenis_hewan' => $this->formatNama($request->nama_jenis_hewan),
            ]);

            return redirect()->route('admin.jenish.index')
                ->with('success', 'Data jenis hewan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data jenis hewan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $jenisHewan = JenisHewan::findOrFail($id);
            $jenisHewan->delete();

            return redirect()->route('admin.jenish.index')
                ->with('success', 'Data jenis hewan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data jenis hewan: ' . $e->getMessage());
        }
    }

    /**
     * Validate jenis hewan data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'nama_jenis_hewan' => 'required|string|max:255|unique:jenis_hewan,nama_jenis_hewan' . ($id ? ',' . $id . ',idjenis_hewan' : ''),
        ];

        $messages = [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 255 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah ada.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new jenis hewan record
     */
    private function createRecord(Request $request)
    {
        return JenisHewan::create([
            'nama_jenis_hewan' => $this->formatNama($request->nama_jenis_hewan),
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
