@extends('layouts.lte.main')

@section('content')
<div class="container">
    <h1>Detail Rekam Medis #{{ $detailRekamMedis->iddetail_rekam_medis }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Rekam Medis ID:</strong> {{ $detailRekamMedis->idrekam_medis }}</p>
            <p><strong>Tindakan:</strong> {{ $detailRekamMedis->tindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}</p>
            <p><strong>Detail:</strong> {{ $detailRekamMedis->detail ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ route('dokter.detail_rekam_medis.edit', $detailRekamMedis->iddetail_rekam_medis) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('dokter.detail_rekam_medis.destroy', $detailRekamMedis->iddetail_rekam_medis) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
    </form>
    <a href="{{ route('dokter.rekam_medis.show', $detailRekamMedis->idrekam_medis) }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
