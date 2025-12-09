@extends('layouts.lte.main')

@section('title', 'Appointments')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Appointments</h1>
        <a href="{{ route('resepsionis.appointments.create') }}" class="btn btn-primary">Create Appointment</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pet</th>
                <th>Owner</th>
                <th>Breed</th>
                <th>Warna Tanda</th>
                <th>Doctor</th>
                <th>Waktu Daftar</th>
                <th>No. Urut</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments ?? [] as $a)
                <tr>
                    <td>{{ $a->idreservasi_dokter }}</td>
                    <td>{{ optional($a->pet)->nama ?? '-' }}</td>
                    <td>{{ optional(optional($a->pet)->pemilik->user)->nama ?? optional($a->pet->pemilik)->no_wa ?? '-' }}</td>
                    <td>{{ optional(optional($a->pet)->rasHewan)->nama_ras ?? '-' }}</td>
                    <td>{{ optional($a->pet)->warna_tanda ?? '-' }}</td>
                    <td>{{ optional(optional($a->roleUser)->user)->nama ?? ('Dokter #' . (optional($a->roleUser)->idrole_user ?? '-')) }}</td>
                    <td>{{ optional($a->waktu_daftar)->format('Y-m-d H:i') ?? '-' }}</td>
                    <td>{{ $a->no_urut ?? '-' }}</td>
                    
                    <td>
                        @php
                            $status = $a->status;
                            if ($status === 1 || $status === '1' || strtolower((string)$status) === 'pending') {
                                $statusLabel = 'pending';
                            } elseif ($status === 2 || $status === '2' || strtolower((string)$status) === 'selesai' || strtolower((string)$status) === 'finished') {
                                $statusLabel = 'selesai';
                            } else {
                                $statusLabel = $status;
                            }
                        @endphp
                        {{ $statusLabel }}
                    </td>
                    <td>
                        <a href="{{ route('resepsionis.appointments.edit', $a->idreservasi_dokter) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('resepsionis.appointments.destroy', $a->idreservasi_dokter) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus appointment?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(method_exists($appointments ?? null, 'links'))
        {{ $appointments->links() }}
    @endif
</div>
@endsection
