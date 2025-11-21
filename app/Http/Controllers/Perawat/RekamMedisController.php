<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Pet;
use App\Models\TemuDokter;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of medical records.
     */
    public function index()
    {
        // Get all medical records with relationships
        $rekamMedis = RekamMedis::with(['pet.pemilik.user', 'temuDokter', 'dokterPemeriksa.user', 'detailRekamMedis'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('perawat.RekamMedis.index', [
            'rekamMedis' => $rekamMedis,
        ]);
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create()
    {
        // Get all pets to select from
        $pets = Pet::with('pemilik.user', 'rasHewan.jenisHewan')
            ->orderBy('nama', 'asc')
            ->get();

        // Get all doctors (users with role Dokter)
        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })
            ->get();

        // Get appointments (TemuDokter) that don't have medical records yet
        $appointments = TemuDokter::with('pet.pemilik.user', 'roleUser.user')
            ->whereDoesntHave('rekamMedis')
            ->where('status', 'selesai')
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        return view('perawat.RekamMedis.create', [
            'pets' => $pets,
            'doctors' => $doctors,
            'appointments' => $appointments,
        ]);
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'anamnesa' => 'required|string|max:1000',
            'temuan_klinis' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'idreservasi_dokter' => 'nullable|exists:temu_dokter,idreservasi_dokter',
        ]);

        try {
            $rekamMedis = RekamMedis::create($validated);

            return redirect()
                ->route('perawat.rekam_medis.show', $rekamMedis->idrekam_medis)
                ->with('success', 'Rekam medis berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat membuat rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified medical record.
     */
    public function show(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['pet.pemilik.user', 'temuDokter', 'dokterPemeriksa.user', 'detailRekamMedis.tindakanTerapi']);

        return view('perawat.RekamMedis.show', [
            'rekamMedis' => $rekamMedis,
        ]);
    }

    /**
     * Show the form for editing the specified medical record.
     */
    public function edit(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['pet', 'temuDokter', 'dokterPemeriksa']);

        // Get all pets
        $pets = Pet::with('pemilik.user', 'rasHewan.jenisHewan')
            ->orderBy('nama', 'asc')
            ->get();

        // Get all doctors
        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })
            ->get();

        // Get appointments
        $appointments = TemuDokter::with('pet.pemilik.user', 'roleUser.user')
            ->where(function ($query) use ($rekamMedis) {
                $query->whereDoesntHave('rekamMedis')
                    ->orWhere('idreservasi_dokter', $rekamMedis->idreservasi_dokter);
            })
            ->where('status', 'selesai')
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        return view('perawat.RekamMedis.edit', [
            'rekamMedis' => $rekamMedis,
            'pets' => $pets,
            'doctors' => $doctors,
            'appointments' => $appointments,
        ]);
    }

    /**
     * Update the specified medical record in storage.
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'anamnesa' => 'required|string|max:1000',
            'temuan_klinis' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'idreservasi_dokter' => 'nullable|exists:temu_dokter,idreservasi_dokter',
        ]);

        try {
            $rekamMedis->update($validated);

            return redirect()
                ->route('perawat.rekam_medis.show', $rekamMedis->idrekam_medis)
                ->with('success', 'Rekam medis berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        try {
            // Delete associated detail records first
            $rekamMedis->detailRekamMedis()->delete();
            
            $rekamMedis->delete();

            return redirect()
                ->route('perawat.rekam_medis.index')
                ->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus rekam medis: ' . $e->getMessage());
        }
    }
}
