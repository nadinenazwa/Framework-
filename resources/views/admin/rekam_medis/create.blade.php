@extends('layouts.lte.main')

@section('title', 'Buat Rekam Medis - Admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Buat Rekam Medis</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.rekam-medis.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pet</label>
                    <select name="idpet" class="form-control">
                        <option value="">Pilih Pet</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->idpet }}">{{ $pet->nama }} - {{ optional($pet->pemilik)->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Anamnesa</label>
                    <textarea name="anamnesa" class="form-control" rows="3">{{ old('anamnesa') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Temuan Klinis</label>
                    <textarea name="temuan_klinis" class="form-control" rows="3">{{ old('temuan_klinis') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diagnosa</label>
                    <textarea name="diagnosa" class="form-control" rows="2">{{ old('diagnosa') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokter Pemeriksa</label>
                    <select name="dokter_pemeriksa" class="form-control">
                        <option value="">Pilih Dokter</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->idrole_user }}">{{ optional($d->user)->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Reservasi (opsional)</label>
                    <select name="idreservasi_dokter" class="form-control">
                        <option value="">Pilih Reservasi</option>
                        @foreach($appointments as $a)
                            <option value="{{ $a->idreservasi_dokter }}">#{{ $a->no_urut }} - {{ optional($a->pet)->nama }} ({{ optional($a->roleUser->user)->name }})</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
