<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        // Provide a list of RekamMedis for the currently authenticated doctor.
        // Resolve the doctor's RoleUser entry for the logged-in user.
        $user = auth()->user();
        $roleUser = $user->roleUser()->whereHas('role', function ($q) {
            $q->where('nama_role', 'Dokter');
        })->first();

        $query = RekamMedis::with(['temuDokter.pet', 'dokterPemeriksa.user', 'detailRekamMedis'])
            ->whereHas('temuDokter', function ($q) use ($roleUser) {
                if ($roleUser) {
                    $q->where('idrole_user', $roleUser->idrole_user);
                }
            })
            ->orderBy('idrekam_medis', 'desc');

        // If route provides a petId param (from some links), filter by it
        if (request()->has('petId')) {
            $petId = request()->get('petId');
            $query->whereHas('temuDokter', function ($q) use ($petId) {
                $q->where('idpet', $petId);
            });
        }

        $rekamMedis = $query->get();

        return view('dokter.rekam_medis.index', compact('rekamMedis'));
    }

    public function edit(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['temuDokter.pet', 'dokterPemeriksa.user', 'detailRekamMedis']);
        return view('dokter.rekam_medis.edit', compact('rekamMedis'));
    }

    public function show(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['temuDokter.pet', 'dokterPemeriksa.user', 'detailRekamMedis.tindakanTerapi']);
        return view('dokter.rekam_medis.show', compact('rekamMedis'));
    }

    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $validated = $request->validate([
            'diagnosa' => 'nullable|string|max:1000',
            'anamnesa' => 'nullable|string|max:1000',
            'temuan_klinis' => 'nullable|string|max:1000',
        ]);

        $rekamMedis->update($validated);

        // After the Dokter updates the RekamMedis (adds medical details),
        // mark the related reservation as completed. Use status code '2'
        // which corresponds to 'Selesai' in the application.
        try {
            if ($rekamMedis->idreservasi_dokter) {
                $rekamMedis->temuDokter()->update(['status' => '2']);
            }
        } catch (\Exception $e) {
            \Log::warning('Dokter\RekamMedisController::update could not update TemuDokter status: ' . $e->getMessage(), ['idrekam_medis' => $rekamMedis->idrekam_medis]);
        }

        return redirect()->route('dokter.rekam_medis.index', ['petId' => $rekamMedis->temuDokter->idpet ?? $rekamMedis->temuDokter->pet->idpet ?? null])
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(RekamMedis $rekamMedis)
    {
        try {
            // set deleted_by on each detail and soft-delete them
            foreach ($rekamMedis->detailRekamMedis()->get() as $detail) {
                $detail->deleted_by = auth()->id();
                $detail->save();
                $detail->delete();
            }

            // set deleted_by on rekam medis and soft-delete
            $rekamMedis->deleted_by = auth()->id();
            $rekamMedis->save();
            $rekamMedis->delete();

            return back()->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus rekam medis: ' . $e->getMessage());
        }
    }
}