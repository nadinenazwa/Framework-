@extends('layouts.lte.main')

@section('title', 'Riwayat Rekam Medis')

@section('content')
<div class="container">
    <h1>Riwayat Rekam Medis</h1>

    @forelse($pets as $pet)
        <div class="card mb-3">
            <div class="card-header">
                <strong>{{ $pet->nama ?? 'Pasien' }}</strong>
                <span class="text-muted">— {{ optional($pet->rasHewan)->nama_ras ?? '' }}</span>
            </div>
            <div class="card-body">
                @php
                    $temuList = $pet->temuDokter ?? collect();
                @endphp

                @if($temuList->isEmpty())
                    <p class="text-muted">Belum ada rekam medis untuk pasien ini.</p>
                @else
                    <ul class="list-group">
                        @foreach($temuList as $temu)
                            @if($temu->rekamMedis)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <div><strong>Kunjungan:</strong> {{ optional($temu->waktu_daftar)->format('d M Y H:i') ?? '-' }}</div>
                                        <div><strong>Dokter:</strong> {{ optional(optional($temu->rekamMedis)->dokterPemeriksa->user)->nama ?? '-' }}</div>
                                        <div class="mt-2"><strong>Diagnosa:</strong> {{ optional($temu->rekamMedis)->diagnosa ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <a href="{{ route('pemilik.rekam_medis.detail', optional($temu->rekamMedis)->idrekam_medis) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Anda belum memiliki hewan terdaftar.</p>
    @endforelse
</div>
@endsection
