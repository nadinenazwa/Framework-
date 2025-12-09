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
    public function index($petId)
    {
        // Fetch rekam medis using idreservasi_dokter to access pet data
        $rekamMedis = RekamMedis::whereHas('temuDokter.pet', function ($query) use ($petId) {
            $query->where('idpet', $petId);
        })->with(['dokterPemeriksa', 'temuDokter.pet'])->get();

        return view('dokter.rekam_medis.index', [
            'rekamMedis' => $rekamMedis,
        ]);
    }

    /**
     * Show the form for creating a new detail medical record.
     */
    public function create(RekamMedis $rekamMedis)
    {
        // Verify this is a medical record created by the current doctor
        $rekamMedis->load('temuDokter.pet.pemilik.user', 'dokterPemeriksa.user', 'detailRekamMedis.tindakanTerapi');

        // Get all treatment/therapy codes
        $tindakanTerapi = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')
            ->orderBy('deskripsi_tindakan_terapi', 'asc')
            ->get();

        return view('dokter.detail_rekam_medis.create', [
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
            $rekamMedis->loadMissing('temuDokter.pet');
            // After a Dokter adds a detail to the RekamMedis, mark the
            // associated TemuDokter reservation as completed ('2').
            try {
                if ($rekamMedis->idreservasi_dokter) {
                    $rekamMedis->temuDokter()->update(['status' => '2']);
                }
            } catch (\Exception $e) {
                \Log::warning('DetailRekamMedisController::store could not update TemuDokter status: ' . $e->getMessage(), ['idrekam_medis' => $rekamMedis->idrekam_medis]);
            }
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
        $detailRekamMedis->load(['rekamMedis.temuDokter.pet.pemilik.user', 'rekamMedis.dokterPemeriksa.user', 'tindakanTerapi.kategori']);

        return view('dokter.detail_rekam_medis.show', [
            'detailRekamMedis' => $detailRekamMedis,
        ]);
    }

    /**
     * Show the form for editing the specified detail medical record.
     */
    public function edit(DetailRekamMedis $detailRekamMedis)
    {
        $detailRekamMedis->load('rekamMedis.temuDokter.pet', 'tindakanTerapi');

        // Get all treatment/therapy codes
        $tindakanTerapi = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')
            ->orderBy('deskripsi_tindakan_terapi', 'asc')
            ->get();

        return view('dokter.detail_rekam_medis.edit', [
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

            $detailRekamMedis->rekamMedis->loadMissing('temuDokter.pet');
            // Ensure the related TemuDokter is marked completed after update.
            try {
                $parent = $detailRekamMedis->rekamMedis;
                if ($parent && $parent->idreservasi_dokter) {
                    $parent->temuDokter()->update(['status' => '2']);
                }
            } catch (\Exception $e) {
                \Log::warning('DetailRekamMedisController::update could not update TemuDokter status: ' . $e->getMessage(), ['iddetail' => $detailRekamMedis->iddetail_rekam_medis ?? null]);
            }
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
        $detailRekamMedis->rekamMedis->loadMissing('temuDokter.pet');
        $petId = $detailRekamMedis->rekamMedis->pet ? $detailRekamMedis->rekamMedis->pet->idpet : null;

        try {
            $detailRekamMedis->deleted_by = auth()->id();
            $detailRekamMedis->save();
            $detailRekamMedis->delete();

            return redirect()
                ->route('dokter.rekam_medis.index', $petId)
                ->with('success', 'Detail rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus detail rekam medis: ' . $e->getMessage());
        }
    }
}
