@extends('layouts.lte.main')

@section('title', 'Edit Rekam Medis - Admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Edit Rekam Medis</h3></div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.rekam-medis.update', $rekamMedis->idrekam_medis) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Pet</label>
                    <input type="text" class="form-control" value="{{ optional($rekamMedis->temuDokter->pet)->nama }} - {{ optional($rekamMedis->temuDokter->pet->pemilik)->nama }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Anamnesa</label>
                    <textarea name="anamnesa" class="form-control" rows="3">{{ old('anamnesa', $rekamMedis->anamnesa) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Temuan Klinis</label>
                    <textarea name="temuan_klinis" class="form-control" rows="3">{{ old('temuan_klinis', $rekamMedis->temuan_klinis) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diagnosa</label>
                    <textarea name="diagnosa" class="form-control" rows="2">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokter Pemeriksa</label>
                    <select name="dokter_pemeriksa" class="form-control">
                        <option value="">Pilih Dokter</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->idrole_user }}" {{ $d->idrole_user == $rekamMedis->dokter_pemeriksa ? 'selected' : '' }}>{{ optional($d->user)->nama }}</option>
                        @endforeach
                    </select>
                </div>
        
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
