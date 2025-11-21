<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemuDokter;
use App\Models\Pet;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TemuDokterController extends Controller
{
    public function index()
    {
        $items = TemuDokter::with(['pet.pemilik.user', 'roleUser.user'])
            ->orderBy('waktu_daftar', 'desc')
            ->paginate(20);

        return view('admin.temu_dokter.index', compact('items'));
    }

    public function create()
    {
        $pets = Pet::with('pemilik.user')->orderBy('nama', 'asc')->get();

        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })->get();

        return view('admin.temu_dokter.create', compact('pets', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'nullable|exists:role_user,idrole_user',
            'status' => 'nullable|in:1,2',
        ]);

        try {
            $today = Carbon::now();
            $maxNo = TemuDokter::whereDate('waktu_daftar', $today->toDateString())->max('no_urut');
            $nextNo = $maxNo ? $maxNo + 1 : 1;

            TemuDokter::create([
                'idpet' => $validated['idpet'],
                'idrole_user' => $validated['idrole_user'] ?? null,
                'waktu_daftar' => $today,
                'status' => $validated['status'] ?? '1',
                'no_urut' => $nextNo,
            ]);

            return redirect()->route('admin.temu-dokter.index')->with('success', 'Temu dokter berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TemuDokter $temuDokter)
    {
        $pets = Pet::with('pemilik.user')->orderBy('nama', 'asc')->get();

        $doctors = RoleUser::with('user')
            ->whereHas('role', function ($query) {
                $query->where('nama_role', 'Dokter');
            })->get();

        return view('admin.temu_dokter.edit', compact('temuDokter', 'pets', 'doctors'));
    }

    public function update(Request $request, TemuDokter $temuDokter)
    {
        $validated = $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'idrole_user' => 'required|exists:role_user,idrole_user',
            'status' => 'required|in:1,2',
            'no_urut' => 'nullable|numeric',
        ]);

        try {
            $temuDokter->update([
                'idpet' => $validated['idpet'],
                'idrole_user' => $validated['idrole_user'],
                'status' => $validated['status'],
                'no_urut' => $validated['no_urut'] ?? $temuDokter->no_urut,
            ]);

            return redirect()->route('admin.temu-dokter.index')->with('success', 'Reservasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(TemuDokter $temuDokter)
    {
        try {
            $temuDokter->delete();
            return redirect()->route('admin.temu-dokter.index')->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }
}
