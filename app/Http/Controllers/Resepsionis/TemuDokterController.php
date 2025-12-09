<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter; 
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\RoleUser;
use Carbon\Carbon;

class TemuDokterController extends Controller
{
    public function index()
    {
        // Ambil data temu_dokter yang statusnya 'Menunggu' (asumsi status '1')
        $daftarTunggu = TemuDokter::with(['pet.pemilik.user', 'roleUser.user'])            ->where('status', '1') // Hanya tampilkan yang sedang menunggu
            ->orderBy('no_urut', 'asc')
            ->get();
            
        // Tampilkan view daftar tunggu
        return view('resepsionis.temu_dokter.index', compact('daftarTunggu'));
    }

    /**
     * Show form to create new temu dokter (reservation).
     */
    public function create()
    {
        $pets = Pet::with('pemilik.user')->orderBy('nama', 'asc')->get();

        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })->get();

        return view('resepsionis.temu_dokter.create', compact('pets', 'doctors'));
    }

    /**
     * Store new temu dokter reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'nullable|exists:role_user,idrole_user',
            'status' => 'nullable|string',
        ]);

        try {
            $today = Carbon::now();
            $maxNo = TemuDokter::whereDate('waktu_daftar', $today->toDateString())->max('no_urut');
            $nextNo = $maxNo ? $maxNo + 1 : 1;

            // Always set new reservations created by Resepsionis to 'pending'
            // (status code '1'). Ignore any incoming status value from the form
            // to enforce the workflow requirement.
            $data = [
                'idpet' => $validated['idpet'],
                'idrole_user' => $validated['idrole_user'] ?? null,
                'waktu_daftar' => $today,
                'status' => '1',
                'no_urut' => $nextNo,
            ];

            TemuDokter::create($data);

            return redirect()->route('resepsionis.temu_dokter.index')
                ->with('success', 'Temu dokter berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified reservation.
     */
    public function show(TemuDokter $temuDokter)
    {
        $temuDokter->load(['pet.pemilik.user', 'roleUser.user', 'rekamMedis']);
        return view('resepsionis.temu_dokter.show', compact('temuDokter'));
    }

    /**
     * Show form for editing a reservation.
     */
    public function edit(TemuDokter $temuDokter)
    {
        $pets = Pet::with('pemilik.user')->orderBy('nama', 'asc')->get();

        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })->get();

        return view('resepsionis.temu_dokter.edit', compact('temuDokter', 'pets', 'doctors'));
    }

    /**
     * Update the specified reservation.
     */
    public function update(Request $request, TemuDokter $temuDokter)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'nullable|exists:role_user,idrole_user',
            'status' => 'nullable|string',
            'no_urut' => 'nullable|numeric',
        ]);

        try {
            $temuDokter->update([
                'idpet' => $validated['idpet'],
                'idrole_user' => $validated['idrole_user'] ?? null,
                'status' => $validated['status'] ?? $temuDokter->status,
                'no_urut' => $validated['no_urut'] ?? $temuDokter->no_urut,
            ]);

            return redirect()->route('resepsionis.temu_dokter.show', $temuDokter->idreservasi_dokter)
                ->with('success', 'Reservasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(TemuDokter $temuDokter)
    {
        try {
            $temuDokter->deleted_by = auth()->id();
            $temuDokter->save();
            $temuDokter->delete();

            return redirect()->route('resepsionis.temu_dokter.index')
                ->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }
}