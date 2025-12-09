<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\Pet;
use App\Models\TemuDokter;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of medical records.
     */
    public function index()
    {
        // Perawat should not access a global rekam-medis index.
        // Redirect them to the appointment list (antrian).
        return redirect()->route('perawat.antrian.index');
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create()
    {
        // Require that this create is initiated from an appointment (temu dokter)
        $temuId = request()->get('temu_dokter_id') ?? request()->get('idreservasi_dokter');
        if (!$temuId) {
            abort(403, 'Akses tidak diperbolehkan. Buat rekam medis hanya melalui daftar temu dokter.');
        }

        $temu = TemuDokter::with('pet.pemilik.user', 'roleUser.user')
            ->where('idreservasi_dokter', $temuId)
            ->first();

        if (!$temu) {
            abort(404, 'Temu dokter tidak ditemukan.');
        }

        // Allow creation from the appointment regardless of textual/numeric status codes.
        // The store() method will still validate duplicates and pet/appointment consistency.

        // Prepare minimal data for the form: provide single appointment and flag
        $appointments = collect([$temu]);

        return view('perawat.rekam_medis.create', [
            'appointments' => $appointments,
            'appointment' => $temu,
            'fromTemu' => true,
        ]);
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request)
    {
        // If the request is missing appointment or doctor info, try to derive from TemuDokter
        if (!$request->filled('idreservasi_dokter') || !$request->filled('dokter_pemeriksa')) {
            $temuId = $request->get('idreservasi_dokter') ?? $request->get('temu_dokter_id');
            $temu = null;
            if ($temuId) {
                $temu = TemuDokter::with('roleUser')->where('idreservasi_dokter', $temuId)->first();
            }
            // fallback: try find latest temu for given pet
            if (!$temu && $request->filled('idpet')) {
                $temu = TemuDokter::with('roleUser')
                    ->where('idpet', $request->get('idpet'))
                    ->orderBy('waktu_daftar', 'desc')
                    ->first();
            }

            if ($temu) {
                if (!$request->filled('idreservasi_dokter')) {
                    $request->merge(['idreservasi_dokter' => $temu->idreservasi_dokter]);
                }
                if (!$request->filled('dokter_pemeriksa') && $temu->roleUser) {
                    $request->merge(['dokter_pemeriksa' => $temu->roleUser->idrole_user]);
                }
            }
        }

        $validated = $request->validate([
            'anamnesa' => 'required|string|max:1000',
            'temuan_klinis' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'dokter_pemeriksa' => 'required|exists:role_user,idrole_user',
            'idreservasi_dokter' => 'required|exists:temu_dokter,idreservasi_dokter',
        ]);

        try {
            // ensure the temu_dokter exists and get its pet via the temu record
            $temu = TemuDokter::where('idreservasi_dokter', $validated['idreservasi_dokter'])->first();

            if (!$temu) {
                return redirect()->back()->withErrors(['idreservasi_dokter' => 'Temu dokter tidak ditemukan atau tidak valid.']);
            }

            if (TemuDokter::where('idreservasi_dokter', $validated['idreservasi_dokter'])->whereHas('rekamMedis')->exists()) {
                return redirect()->back()->withErrors(['idreservasi_dokter' => 'Sudah ada rekam medis untuk temu dokter ini.']);
            }

            // Validate reservation status: only allow creating RekamMedis when
            // the TemuDokter is in 'pending' state. Accept common encodings
            // (numeric '1' or textual 'pending'/'menunggu'). If the
            // reservation was cancelled, reject explicitly.
            $statusVal = strtolower((string) $temu->status);
            $pendingValues = ['1', 'pending', 'menunggu'];
            $cancelledValues = ['cancelled', 'batal', 'cancel', '0'];

            if (!in_array($statusVal, $pendingValues, true)) {
                if (in_array($statusVal, $cancelledValues, true)) {
                    return redirect()->back()->withErrors(['idreservasi_dokter' => 'Reservasi telah dibatalkan. Rekam medis tidak dapat dibuat.']);
                }
                return redirect()->back()->withErrors(['idreservasi_dokter' => 'Rekam medis hanya dapat dibuat untuk reservasi berstatus pending/menunggu.']);
            }

            // Log validated payload
            Log::info('RekamMedis::store validated payload', $validated);

            try {
                $rekamMedis = RekamMedis::create($validated);
                if (!$rekamMedis) {
                    Log::error('RekamMedis::store creation returned null', $validated);
                    return redirect()->back()->withInput()->with('error', 'Gagal membuat rekam medis (no record returned).');
                }
            } catch (\Exception $e) {
                Log::error('RekamMedis::store exception: ' . $e->getMessage(), ['exception' => $e, 'payload' => $validated]);
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat membuat rekam medis: ' . $e->getMessage());
            }

            // Per the workflow: when Perawat creates a RekamMedis, the
            // reservation must remain in 'pending' state. Do NOT change the
            // TemuDokter.status here. The Dokter is responsible for
            // completing the reservation after adding detail rekam medis.

            return redirect()
                ->route('perawat.rekam-medis.show', $rekamMedis->idrekam_medis)
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
        // allow viewing only if rekam medis terkait dengan temu dokter
        if (!$rekamMedis->idreservasi_dokter) {
            abort(403, 'Rekam medis ini tidak dapat diakses dari menu perawat.');
        }

        // pet is reached via the related temuDokter, so eager-load that chain
        $rekamMedis->load(['temuDokter.pet.pemilik.user', 'dokterPemeriksa.user', 'detailRekamMedis.tindakanTerapi']);

        return view('perawat.rekam_medis.show', [
            'rekamMedis' => $rekamMedis,
        ]);
    }

    /**
     * Show the form for editing the specified medical record.
     */
    public function edit(RekamMedis $rekamMedis)
    {
        if (!$rekamMedis->idreservasi_dokter) {
            abort(403, 'Rekam medis ini tidak dapat diedit dari menu perawat.');
        }
        // pet is available via temuDokter; eager-load that chain instead
        $rekamMedis->load([
            'temuDokter.pet.rasHewan.jenisHewan',
            'temuDokter.pet.pemilik.user',
            'temuDokter',
            'dokterPemeriksa',
        ]);

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
            // DB stores status codes as char(1): '2' corresponds to 'Selesai'
            ->where('status', '2')
            ->orderBy('waktu_daftar', 'desc')
            ->get();

        return view('perawat.rekam_medis.edit', [
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
        if (!$rekamMedis->idreservasi_dokter) {
            abort(403, 'Rekam medis ini tidak dapat diperbarui dari menu perawat.');
        }
        $validated = $request->validate([
            'anamnesa' => 'required|string|max:1000',
            'temuan_klinis' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
        ]);

        try {
            $rekamMedis->update($validated);

            return redirect()
                ->route('perawat.rekam-medis.show', $rekamMedis->idrekam_medis)
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
        if (!$rekamMedis->idreservasi_dokter) {
            abort(403, 'Rekam medis ini tidak dapat dihapus dari menu perawat.');
        }
        try {
            $rekamMedis->deleted_by = auth()->id();
            $rekamMedis->save();
            $rekamMedis->delete();

            // redirect back to the appointment list
            return redirect()->route('perawat.antrian.index')
                ->with('success', 'Rekam medis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus rekam medis: ' . $e->getMessage());
        }
    }
}
