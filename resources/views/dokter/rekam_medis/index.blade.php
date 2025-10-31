<h1>Riwayat Rekam Medis: {{ $pasien->nama }}</h1>
<a href="{{ route('dokter.dashboard') }}">Kembali ke Dashboard</a>

<hr>

@forelse($riwayat as $rekam)
    <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
        <h3>Kunjungan: {{ $rekam->created_at ? $rekam->created_at->format('d M Y') : $rekam->temuDokter->waktu_daftar->format('d M Y') }}</h3>
        <p><strong>Dokter Pemeriksa:</strong> {{ $rekam->dokterPemeriksa->user->nama ?? 'N/A' }}</p>
        <p><strong>Anamnesa:</strong> {{ $rekam->anamnesa }}</p>
        <p><strong>Temuan Klinis:</strong> {{ $rekam->temuan_klinis }}</p>
        <p><strong>Diagnosa:</strong> {{ $rekam->diagnosa }}</p>

        <h4>Detail Tindakan / Terapi:</h4>
        <ul>
            @foreach($rekam->detailRekamMedis as $detail)
            <li>
                <strong>{{ $detail->tindakanTerapi->deskripsi_tindakan_terapi ?? 'Tindakan' }}:</strong>
                {{ $detail->detail }}
            </li>
            @endforeach
        </ul>
    </div>
@empty
    <p>Belum ada riwayat rekam medis untuk pasien ini.</p>
@endforelse