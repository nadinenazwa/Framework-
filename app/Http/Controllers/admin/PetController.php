<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RasHewan;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with(['pemilik.user', 'rasHewan'])->get();
        return view('admin.Pet.index', compact('pets'));
    }

    public function create()
    {
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::with('jenisHewan')->get();
        return view('admin.Pet.create', compact('pemilik', 'rasHewan'));
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

            return redirect()->route('admin.pet.index')
                ->with('success', 'Data pet berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data pet: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pet = Pet::with(['pemilik', 'rasHewan'])->findOrFail($id);
        $pemilik = Pemilik::with('user')->get();
        $rasHewan = RasHewan::with('jenisHewan')->get();
        return view('admin.Pet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $validator = $this->validateData($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $pet->update([
                'nama' => $this->formatNama($request->nama),
                'tanggal_lahir' => $request->tanggal_lahir,
                'warna_tanda' => ucfirst(trim($request->warna_tanda)),
                'jenis_kelamin' => $request->jenis_kelamin,
                'idpemilik' => $request->idpemilik,
                'idras_hewan' => $request->idras_hewan,
            ]);

            return redirect()->route('admin.pet.index')
                ->with('success', 'Data pet berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data pet: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pet = Pet::findOrFail($id);
            $pet->delete();

            return redirect()->route('admin.pet.index')
                ->with('success', 'Data pet berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data pet: ' . $e->getMessage());
        }
    }

    /**
     * Validate pet data
     */
    private function validateData(Request $request, $id = null)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'warna_tanda' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:jantan,betina',
            'idpemilik' => 'required|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
        ];

        $messages = [
            'nama.required' => 'Nama pet wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'warna_tanda.required' => 'Warna/tanda wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus jantan atau betina.',
            'idpemilik.required' => 'Pemilik wajib dipilih.',
            'idpemilik.exists' => 'Pemilik tidak valid.',
            'idras_hewan.required' => 'Ras hewan wajib dipilih.',
            'idras_hewan.exists' => 'Ras hewan tidak valid.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    /**
     * Create new pet record
     */
    private function createRecord(Request $request)
    {
        return Pet::create([
            'nama' => $this->formatNama($request->nama),
            'tanggal_lahir' => $request->tanggal_lahir,
            'warna_tanda' => ucfirst(trim($request->warna_tanda)),
            'jenis_kelamin' => $request->jenis_kelamin,
            'idpemilik' => $request->idpemilik,
            'idras_hewan' => $request->idras_hewan,
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