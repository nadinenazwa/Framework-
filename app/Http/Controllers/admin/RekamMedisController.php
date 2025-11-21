<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Pet;
use App\Models\TemuDokter;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pet.pemilik.user', 'temuDokter', 'dokterPemeriksa.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.rekam_medis.index', compact('rekamMedis'));
    }

    public function create()
    {
        $pets = Pet::with('pemilik.user')->orderBy('nama', 'asc')->get();

        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })->get();

        $appointments = TemuDokter::with('pet.pemilik.user', 'roleUser.user')
            ->whereDoesntHave('rekamMedis')
            ->where('status', 2)
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        return view('admin.rekam_medis.create', compact('pets', 'doctors', 'appointments'));
    }

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

            return redirect()->route('admin.rekam-medis.index')->with('success', 'Rekam medis berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat membuat rekam medis: ' . $e->getMessage());
        }
    }

    public function edit(RekamMedis $rekamMedis)
    {
        $pets = Pet::with('pemilik.user')->orderBy('nama', 'asc')->get();

        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })->get();

        $appointments = TemuDokter::with('pet.pemilik.user', 'roleUser.user')
            ->where(function ($query) use ($rekamMedis) {
                $query->whereDoesntHave('rekamMedis')
                    ->orWhere('idreservasi_dokter', $rekamMedis->idreservasi_dokter);
            })
            ->where('status', 2)
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        return view('admin.rekam_medis.edit', compact('rekamMedis', 'pets', 'doctors', 'appointments'));
    }

    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $validated = $request->validate([
            'anamnesa' => 'required|string|max:1000',
            'temuan_klinis' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
        ]);

        try {
            $rekamMedis->update($validated);

            return redirect()->route('admin.rekam-medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui rekam medis: ' . $e->getMessage());
        }
    }

    public function destroy(RekamMedis $rekamMedis)
    {
        try {
            $rekamMedis->detailRekamMedis()->delete();
            $rekamMedis->delete();

            return redirect()->route('admin.rekam-medis.index')->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus rekam medis: ' . $e->getMessage());
        }
    }
}
