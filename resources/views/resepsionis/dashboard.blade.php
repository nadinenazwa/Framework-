@extends('layouts.lte.main')

@section('title', 'Dashboard Resepsionis')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Pemilik</h5>
                    <p class="card-text display-6">{{ $totalPemilik }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Pet</h5>
                    <p class="card-text display-6">{{ $totalPet }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Temu Dokter</h5>
                    <p class="card-text display-6">{{ $totalTemuDokter }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Appointments</h3>
            <div class="card-tools">
                <a href="{{ url('/api/resepsionis/appointments') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
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
                        @forelse($recentAppointments as $a)
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
                        <tr><td colspan="5" class="text-center">No recent appointments</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Recent Pets</h3></div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead><tr><th>ID</th><th>Name</th><th>Owner</th></tr></thead>
                        <tbody>
                        @forelse($recentPets as $p)
                            <tr>
                                <td>{{ $p->idpet }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ optional(optional($p->pemilik)->user)->nama ?? optional($p->pemilik)->nama ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No pets</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Recent Owners</h3></div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead><tr><th>ID</th><th>Owner</th><th>No WA</th><th>Alamat</th></tr></thead>
                        <tbody>
                        @forelse($recentOwners as $o)
                            <tr>
                                <td>{{ $o->idpemilik }}</td>
                                <td>{{ optional($o->user)->nama ?? $o->nama ?? '-' }}</td>
                                <td>{{ $o->no_wa }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($o->alamat, 50) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center">No owners</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
