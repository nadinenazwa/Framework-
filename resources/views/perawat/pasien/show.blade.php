@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Riwayat Rekam Medis: {{ $pasien->nama }}</h1>
        <a href="{{ route('perawat.pasien.index') }}" class="btn btn-secondary">Kembali ke Daftar Pasien</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Detail Pasien</h5>
        </div>
        <div class="card-body">
             <p><strong>Nama:</strong> {{ $pasien->nama }}</p>
             <p><strong>Pemilik:</strong> {{ $pasien->pemilik->user->nama ?? 'N/A' }}</p>
             <p><strong>Jenis Hewan:</strong> {{ $pasien->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</p>
             <p><strong>Ras:</strong> {{ $pasien->rasHewan->nama_ras ?? 'N/A' }}</p>
        </div>
    </div>

    <hr>

    <h3>Riwayat Kunjungan</h3>
    @forelse($riwayat as $rekam)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <strong>Kunjungan: {{ $rekam->created_at ? $rekam->created_at->format('d M Y') : $rekam->temuDokter->waktu_daftar->format('d M Y') }}</strong>
                <strong>Dokter: {{ $rekam->dokterPemeriksa->user->nama ?? 'N/A' }}</strong>
            </div>
            <div class="card-body">
                <p><strong>Anamnesa:</strong> {{ $rekam->anamnesa }}</p>
                <p><strong>Temuan Klinis:</strong> {{ $rekam->temuan_klinis }}</p>
                <p><strong>Diagnosa:</strong> {{ $rekam->diagnosa }}</p>

                <h5 class="mt-3">Detail Tindakan / Terapi:</h5>
                <ul class="list-group">
                    @forelse($rekam->detailRekamMedis as $detail)
                    <li class="list-group-item">
                        <strong>{{ $detail->tindakanTerapi->deskripsi_tindakan_terapi ?? 'Tindakan' }}:</strong>
                        {{ $detail->detail }}
                    </li>
                    @empty
                    <li class="list-group-item">Tidak ada detail tindakan/terapi.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada riwayat rekam medis untuk pasien ini.
        </div>
    @endforelse
</div>
@endsection