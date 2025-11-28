@extends('layouts.lte.main')

@section('title', 'Edit Detail Rekam Medis')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">Edit Detail Rekam Medis</h2>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <a href="{{ $detailRekamMedis->rekamMedis && $detailRekamMedis->rekamMedis->pet ? route('dokter.rekam_medis.index', $detailRekamMedis->rekamMedis->pet->idpet) : route('dokter.dashboard') }}" class="btn btn-link btn-sm">Kembali ke Detail Rekam Medis</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <a href="{{ $detailRekamMedis->rekamMedis && $detailRekamMedis->rekamMedis->pet ? route('dokter.rekam_medis.index', $detailRekamMedis->rekamMedis->pet->idpet) : route('dokter.dashboard') }}" class="btn btn-link btn-sm">Kembali ke Detail Rekam Medis</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('dokter.detail_rekam_medis.update', $detailRekamMedis->iddetail_rekam_medis) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="idkode_tindakan_terapi" class="form-label">Tindakan/Terapi</label>
                    <select class="form-select" id="idkode_tindakan_terapi" name="idkode_tindakan_terapi" required>
                        <option value="">-- Pilih Tindakan/Terapi --</option>
                        @foreach($tindakanTerapi as $t)
                            <option value="{{ $t->idkode_tindakan_terapi }}" {{ $detailRekamMedis->idkode_tindakan_terapi == $t->idkode_tindakan_terapi ? 'selected' : '' }}>{{ $t->deskripsi_tindakan_terapi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <textarea class="form-control" id="detail" name="detail" rows="3" required>{{ old('detail', $detailRekamMedis->detail) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ $detailRekamMedis->rekamMedis && $detailRekamMedis->rekamMedis->pet ? route('dokter.rekam_medis.index', $detailRekamMedis->rekamMedis->pet->idpet) : route('dokter.dashboard') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
