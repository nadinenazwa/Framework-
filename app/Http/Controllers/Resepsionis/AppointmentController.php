<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\TemuDokter;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        // eager load pet -> pemilik -> user and pet -> rasHewan and roleUser -> user (dokter)
        // Order by waktu_daftar desc so the latest reservations appear first
        $appointments = TemuDokter::with(['pet.pemilik.user', 'pet.rasHewan', 'roleUser.user.dokter'])
            ->orderBy('waktu_daftar', 'desc')
            ->paginate($perPage);
        if ($request->wantsJson()) {
            return response()->json($appointments);
        }
        return view('resepsionis.appointments.index', ['appointments' => $appointments]);
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        // load owners, pets, and doctors for dropdown selects
        $owners = \App\Models\Pemilik::orderBy('idpemilik','desc')->get();
        $pets = \App\Models\Pet::orderBy('idpet','desc')->get();
        // group pets by owner id for client-side dependent dropdown
        $petsByOwner = $pets->groupBy('idpemilik')->map(function ($group) {
            return $group->map(function ($p) {
                return ['idpet' => $p->idpet, 'nama' => $p->nama];
            })->values();
        });
        // doctors: fetch RoleUser entries where role is 'dokter'
        $dokters = \App\Models\RoleUser::with('user','role')
            ->whereHas('role', function($q){
                $q->where('nama_role', 'dokter')->orWhere('nama_role', 'Dokter');
            })->orderBy('idrole_user','desc')->get();

        return view('resepsionis.appointments.create', [
            'owners' => $owners,
            'pets' => $pets,
            'dokters' => $dokters,
            'petsByOwner' => $petsByOwner,
        ]);
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit($id)
    {
        $appointment = TemuDokter::with(['pet.pemilik.user','roleUser.user'])->findOrFail($id);
        $owners = \App\Models\Pemilik::orderBy('idpemilik','desc')->get();
        $pets = \App\Models\Pet::orderBy('idpet','desc')->get();
        $dokters = \App\Models\RoleUser::with('user')
            ->whereHas('role', function($q){
                $q->where('nama_role', 'dokter')->orWhere('nama_role','Dokter');
            })->orderBy('idrole_user','desc')->get();

        return view('resepsionis.appointments.edit', [
            'appointment' => $appointment,
            'owners' => $owners,
            'pets' => $pets,
            'dokters' => $dokters,
        ]);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();
        // set waktu_daftar to now and enforce business rule: new appointments are always 'pending' (DB stores as '1')
        $today = Carbon::now();
        $data['waktu_daftar'] = $today;
        // store status as the short code used by the DB schema: '1' = Menunggu (pending)
        $data['status'] = '1';

        // Compute per-day sequential no_urut: find the current max for today and increment.
        $maxNo = TemuDokter::whereDate('waktu_daftar', $today->toDateString())->max('no_urut');
        $nextNo = $maxNo ? $maxNo + 1 : 1;
        $data['no_urut'] = $nextNo;

        $appointment = TemuDokter::create($data);
        if ($request->wantsJson()) {
            return response()->json($appointment, 201);
        }
        return redirect()->route('resepsionis.appointments.index')->with('success', 'Appointment created');
    }

    public function update(UpdateAppointmentRequest $request, $id)
    {
        $appointment = TemuDokter::findOrFail($id);
        $appointment->update($request->validated());
        if ($request->wantsJson()) {
            return response()->json($appointment);
        }
        return redirect()->route('resepsionis.appointments.index')->with('success', 'Appointment updated');
    }

    public function destroy($id)
    {
        $appointment = TemuDokter::findOrFail($id);
        $appointment->delete(); // soft delete
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Deleted (soft)'], 200);
        }
        return redirect()->route('resepsionis.appointments.index')->with('success', 'Appointment deleted');
    }

    public function restore($id)
    {
        $appointment = TemuDokter::withTrashed()->where('idreservasi_dokter', $id)->firstOrFail();
        $appointment->restore();
        if (request()->wantsJson()) {
            return response()->json($appointment);
        }
        return redirect()->route('resepsionis.appointments.index')->with('success', 'Appointment restored');
    }
}
