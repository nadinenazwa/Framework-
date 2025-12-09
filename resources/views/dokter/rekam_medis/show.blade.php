@extends('layouts.lte.main')

@section('content')
<div class="container">
    <h1>Rekam Medis #{{ $rekamMedis->idrekam_medis }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Pasien:</strong> {{ $rekamMedis->temuDokter->pet->nama ?? 'N/A' }}</p>
            <p><strong>Dokter Pemeriksa:</strong> {{ $rekamMedis->dokterPemeriksa->user->nama ?? $rekamMedis->dokterPemeriksa->user->name ?? 'N/A' }}</p>
            <p><strong>Anamnesa:</strong> {{ $rekamMedis->anamnesa ?? '-' }}</p>
            <p><strong>Temuan Klinis:</strong> {{ $rekamMedis->temuan_klinis ?? '-' }}</p>
            <p><strong>Diagnosa:</strong> {{ $rekamMedis->diagnosa ?? '-' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Tindakan / Terapi</h5>
            <a href="{{ route('dokter.detail_rekam_medis.create', ['rekamMedis' => $rekamMedis->idrekam_medis]) }}" class="btn btn-primary btn-sm">Tambah Detail</a>
        </div>
        <div class="card-body">
            @if($rekamMedis->detailRekamMedis->count())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tindakan/Terapi</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekamMedis->detailRekamMedis as $detail)
                        <tr>
                            <td>{{ $detail->iddetail_rekam_medis }}</td>
                            <td>{{ $detail->tindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}</td>
                            <td>{{ $detail->detail ?? '-' }}</td>
                            <td>
                                <a href="{{ route('dokter.detail_rekam_medis.edit', $detail->iddetail_rekam_medis) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('dokter.detail_rekam_medis.destroy', $detail->iddetail_rekam_medis) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus detail ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">Belum ada detail tindakan untuk rekam medis ini.</div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
