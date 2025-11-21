<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\JenisHewan;
use App\Models\RasHewan;
use Illuminate\Http\Request;

class PetResepsionisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pets = Pet::with(['pemilik.user', 'jenisHewan', 'rasHewan'])->paginate(15);
            return view('resepsionis.pet.index', compact('pets'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data hewan peliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $pemilik = Pemilik::with('user')->get();
            $jenisHewan = JenisHewan::all();
            $rasHewan = RasHewan::all();
            
            return view('resepsionis.pet.create', compact('pemilik', 'jenisHewan', 'rasHewan'));
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
                'nama_hewan' => 'required|string|max:100',
                'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
                'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
                'warna' => 'nullable|string|max:100',
                'umur' => 'nullable|numeric|min:0',
                'berat_badan' => 'nullable|numeric|min:0',
                'idpemilik' => 'required|exists:pemilik,idpemilik',
            ], [
                'nama_hewan.required' => 'Nama hewan wajib diisi',
                'idjenis_hewan.required' => 'Jenis hewan wajib dipilih',
                'idras_hewan.required' => 'Ras hewan wajib dipilih',
                'idpemilik.required' => 'Pemilik wajib dipilih',
            ]);

            Pet::create($validated);
            
            return redirect()->route('resepsionis.pet.index')
                           ->with('success', 'Hewan peliharaan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan hewan peliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        try {
            $pet->load(['pemilik.user', 'jenisHewan', 'rasHewan']);
            return view('resepsionis.pet.show', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        try {
            $pet->load(['pemilik.user', 'jenisHewan', 'rasHewan']);
            $pemilik = Pemilik::with('user')->get();
            $jenisHewan = JenisHewan::all();
            $rasHewan = RasHewan::all();
            
            return view('resepsionis.pet.edit', compact('pet', 'pemilik', 'jenisHewan', 'rasHewan'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat form edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        try {
            $validated = $request->validate([
                'nama_hewan' => 'required|string|max:100',
                'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
                'idras_hewan' => 'required|exists:ras_hewan,idras_hewan',
                'warna' => 'nullable|string|max:100',
                'umur' => 'nullable|numeric|min:0',
                'berat_badan' => 'nullable|numeric|min:0',
                'idpemilik' => 'required|exists:pemilik,idpemilik',
            ], [
                'nama_hewan.required' => 'Nama hewan wajib diisi',
                'idjenis_hewan.required' => 'Jenis hewan wajib dipilih',
                'idras_hewan.required' => 'Ras hewan wajib dipilih',
                'idpemilik.required' => 'Pemilik wajib dipilih',
            ]);

            $pet->update($validated);
            
            return redirect()->route('resepsionis.pet.show', $pet->idpet)
                           ->with('success', 'Hewan peliharaan berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui hewan peliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        try {
            $pet->delete();
            
            return redirect()->route('resepsionis.pet.index')
                           ->with('success', 'Hewan peliharaan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus hewan peliharaan: ' . $e->getMessage());
        }
    }
}
