@extends('layouts.lte.main')

@section('content')
<div class="container">
    <h1>Edit Detail Rekam Medis #{{ $detailRekamMedis->iddetail_rekam_medis }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('dokter.detail_rekam_medis.update', $detailRekamMedis->iddetail_rekam_medis) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="idkode_tindakan_terapi" class="form-label">Tindakan / Terapi</label>
                    <select name="idkode_tindakan_terapi" id="idkode_tindakan_terapi" class="form-control">
                        <option value="">Pilih Tindakan</option>
                        @foreach($tindakanTerapi as $t)
                            <option value="{{ $t->idkode_tindakan_terapi }}" {{ $detailRekamMedis->idkode_tindakan_terapi == $t->idkode_tindakan_terapi ? 'selected' : '' }}>{{ $t->deskripsi_tindakan_terapi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <textarea name="detail" id="detail" class="form-control" rows="3">{{ old('detail', $detailRekamMedis->detail) }}</textarea>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('dokter.rekam_medis.show', $detailRekamMedis->idrekam_medis) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
