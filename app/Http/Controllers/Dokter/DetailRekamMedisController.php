<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DetailRekamMedis;
use App\Models\RekamMedis;
use App\Models\KodeTindakanTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailRekamMedisController extends Controller
{
    /**
     * Display a listing of detail medical records.
     */
    public function index()
    {
        // Get all detail medical records with relationships
        $detailRekamMedis = DetailRekamMedis::with(['rekamMedis.pet', 'tindakanTerapi'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dokter.DetailRekamMedis.index', [
            'detailRekamMedis' => $detailRekamMedis,
        ]);
    }

    /**
     * Show the form for creating a new detail medical record.
     */
    public function create(RekamMedis $rekamMedis)
    {
        // Verify this is a medical record created by the current doctor
        $rekamMedis->load('pet.pemilik.user', 'dokterPemeriksa.user', 'detailRekamMedis.tindakanTerapi');

        // Get all treatment/therapy codes
        $tindakanTerapi = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')
            ->orderBy('deskripsi_tindakan_terapi', 'asc')
            ->get();

        return view('dokter.DetailRekamMedis.create', [
            'rekamMedis' => $rekamMedis,
            'tindakanTerapi' => $tindakanTerapi,
        ]);
    }

    /**
     * Store a newly created detail medical record in storage.
     */
    public function store(Request $request, RekamMedis $rekamMedis)
    {
        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'required|string|max:1000',
        ]);

        try {
            // Add the rekam_medis id to validated data
            $validated['idrekam_medis'] = $rekamMedis->idrekam_medis;

            $detailRekamMedis = DetailRekamMedis::create($validated);
            $rekamMedis->loadMissing('pet');
            return redirect()
                ->route('dokter.rekam_medis.index', $rekamMedis->pet ? $rekamMedis->pet->idpet : null)
                ->with('success', 'Detail rekam medis berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menambah detail rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified detail medical record.
     */
    public function show(DetailRekamMedis $detailRekamMedis)
    {
        $detailRekamMedis->load(['rekamMedis.pet.pemilik.user', 'rekamMedis.dokterPemeriksa.user', 'tindakanTerapi.kategori']);

        return view('dokter.DetailRekamMedis.show', [
            'detailRekamMedis' => $detailRekamMedis,
        ]);
    }

    /**
     * Show the form for editing the specified detail medical record.
     */
    public function edit(DetailRekamMedis $detailRekamMedis)
    {
        $detailRekamMedis->load('rekamMedis.pet', 'tindakanTerapi');

        // Get all treatment/therapy codes
        $tindakanTerapi = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')
            ->orderBy('deskripsi_tindakan_terapi', 'asc')
            ->get();

        return view('dokter.DetailRekamMedis.edit', [
            'detailRekamMedis' => $detailRekamMedis,
            'tindakanTerapi' => $tindakanTerapi,
        ]);
    }

    /**
     * Update the specified detail medical record in storage.
     */
    public function update(Request $request, DetailRekamMedis $detailRekamMedis)
    {
        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'detail' => 'required|string|max:1000',
        ]);

        try {
            $detailRekamMedis->update($validated);

            $detailRekamMedis->rekamMedis->loadMissing('pet');
            return redirect()
                ->route('dokter.rekam_medis.index', $detailRekamMedis->rekamMedis->pet ? $detailRekamMedis->rekamMedis->pet->idpet : null)
                ->with('success', 'Detail rekam medis berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui detail rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified detail medical record from storage.
     */
    public function destroy(DetailRekamMedis $detailRekamMedis)
    {
        $detailRekamMedis->rekamMedis->loadMissing('pet');
        $petId = $detailRekamMedis->rekamMedis->pet ? $detailRekamMedis->rekamMedis->pet->idpet : null;

        try {
            $detailRekamMedis->delete();

            return redirect()
                ->route('dokter.rekam_medis.index', $petId)
                ->with('success', 'Detail rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus detail rekam medis: ' . $e->getMessage());
        }
    }
}
