@extends('layouts.lte.main')

@section('content')
<div class="container">
    <h1>Edit Rekam Medis</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dokter.rekam_medis.update', $rekamMedis->idrekam_medis) }}" method="POST">
                @csrf
                @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Anamnesa (input Perawat)</label>
                        <textarea class="form-control" rows="3" readonly>{{ $rekamMedis->anamnesa }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Temuan Klinis (input Perawat)</label>
                        <textarea class="form-control" rows="3" readonly>{{ $rekamMedis->temuan_klinis }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="diagnosa" class="form-label">Diagnosa (input Dokter)</label>
                        <textarea name="diagnosa" id="diagnosa" class="form-control" rows="4">{{ $rekamMedis->diagnosa }}</textarea>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('detail_rekam_medis.create', ['rekamMedis' => $rekamMedis->idrekam_medis]) }}" class="btn btn-secondary">Tambah Detail Rekam Medis</a>
                    </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection