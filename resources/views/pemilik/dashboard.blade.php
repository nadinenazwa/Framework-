@extends('layouts.lte.main')

@section('title', 'Dashboard Pemilik')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Pet</h5>
                    <p class="card-text display-6">{{ $totalPets ?? ($pets->count() ?? 0) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Appointments</h5>
                    <p class="card-text display-6">{{ optional($upcomingAppointments)->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Recent Medical Records</h5>
                    <p class="card-text display-6">{{ optional($recentRekams)->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Upcoming Appointments</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pet</th>
                                <th>Doctor</th>
                                <th>Waktu Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingAppointments ?? [] as $a)
                                <tr>
                                    <td>{{ $a->idreservasi_dokter }}</td>
                                    <td>{{ optional($a->pet)->nama ?? '-' }}</td>
                                    <td>{{ optional(optional($a->roleUser)->user)->nama ?? '-' }}</td>
                                    <td>{{ optional($a->waktu_daftar)->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td>
                                        @php
                                            $s = $a->status;
                                            if ($s === 1 || $s === '1' || strtolower((string)$s) === 'pending') {
                                                $label = 'pending';
                                            } elseif ($s === 2 || $s === '2' || strtolower((string)$s) === 'selesai' || strtolower((string)$s) === 'finished') {
                                                $label = 'selesai';
                                            } else {
                                                $label = (string)$s;
                                            }
                                        @endphp
                                        {{ $label }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">No upcoming appointments</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Your Pets</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead><tr><th>#</th><th>Name</th><th>Breed</th></tr></thead>
                        <tbody>
                            @forelse($pets as $idx => $p)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ optional($p->rasHewan)->nama_ras ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No pets</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 class="card-title">Recent Medical Records</h3></div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead><tr><th>ID</th><th>Pet</th><th>Date</th></tr></thead>
                        <tbody>
                            @forelse($recentRekams ?? [] as $r)
                                <tr>
                                    <td>{{ $r->idrekam_medis }}</td>
                                    <td>{{ optional(optional($r->temuDokter)->pet)->nama ?? '-' }}</td>
                                    <td>{{ optional(optional($r->temuDokter)->waktu_daftar)->format('Y-m-d') ?? optional($r->created_at)->format('Y-m-d') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No records</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection