@extends('layouts.lte.main')

@section('title', 'Jadwal Temu Saya')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Jadwal Temu Saya</h1>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pet</th>
                <th>Breed</th>
                <th>Warna Tanda</th>
                <th>Doctor</th>
                <th>Waktu Daftar</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            @forelse($appointments ?? [] as $a)
                <tr>
                    <td>{{ $a->idreservasi_dokter }}</td>
                    <td>{{ optional($a->pet)->nama ?? '-' }}</td>
                    <td>{{ optional(optional($a->pet)->rasHewan)->nama_ras ?? '-' }}</td>
                    <td>{{ optional($a->pet)->warna_tanda ?? '-' }}</td>
                    <td>{{ optional(optional($a->roleUser)->user)->nama ?? ('Dokter #' . (optional($a->roleUser)->idrole_user ?? '-')) }}</td>
                    <td>{{ optional($a->waktu_daftar)->format('Y-m-d H:i') ?? '-' }}</td>
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
                    
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada temu dokter</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($appointments ?? null, 'links'))
        {{ $appointments->links() }}
    @endif
</div>
@endsection
