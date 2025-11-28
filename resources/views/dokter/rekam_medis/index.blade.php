
<h1>Riwayat Rekam Medis: {{ $pasien->nama }}</h1>
<a href="{{ route('dokter.dashboard') }}">Kembali ke Dashboard</a>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <a href="{{ route('dokter.rekam_medis.index', $pasien->idpet) }}" class="btn btn-link btn-sm">Kembali ke Detail Rekam Medis</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<hr>

@forelse($riwayat as $rekam)
    <div id="detail-rekam-medis" style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
        <h3>Kunjungan: {{ $rekam->created_at ? $rekam->created_at->format('d M Y') : $rekam->temuDokter->waktu_daftar->format('d M Y') }}</h3>
        <p><strong>Dokter Pemeriksa:</strong> {{ $rekam->dokterPemeriksa->user->nama ?? 'N/A' }}</p>
        <p><strong>Anamnesa:</strong> {{ $rekam->anamnesa }}</p>
        <p><strong>Temuan Klinis:</strong> {{ $rekam->temuan_klinis }}</p>
        <p><strong>Diagnosa:</strong> {{ $rekam->diagnosa }}</p>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="mb-0">Detail Tindakan / Terapi:</h4>
            <a href="{{ route('dokter.detail_rekam_medis.create', $rekam->idrekam_medis) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Detail
            </a>
        </div>
        <ul>
            @foreach($rekam->detailRekamMedis as $detail)
            <li>
                <strong>{{ $detail->tindakanTerapi->deskripsi_tindakan_terapi ?? 'Tindakan' }}:</strong>
                {{ $detail->detail }}
                <a href="{{ route('dokter.detail_rekam_medis.edit', $detail->iddetail_rekam_medis) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('dokter.detail_rekam_medis.destroy', $detail->iddetail_rekam_medis) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus detail rekam medis ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </li>
            @endforeach
        </ul>
    </div>
@empty
    <p>Belum ada riwayat rekam medis untuk pasien ini.</p>
@endforelse