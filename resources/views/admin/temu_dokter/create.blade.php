@extends('layouts.lte.main')

@section('title', 'Buat Temu Dokter - Admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Buat Temu Dokter</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.temu-dokter.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pet</label>
                    <select name="idpet" class="form-control">
                        <option value="">Pilih Pet</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->idpet }}">{{ $pet->nama }} - {{ optional($pet->pemilik)->nama }}</option>
                        @endforeach
                    </select>
                    @error('idpet')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokter (opsional)</label>
                    <select name="idrole_user" class="form-control">
                        <option value="">Pilih Dokter</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->idrole_user }}">{{ optional($d->user)->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Menunggu</option>
                        <option value="2">Selesai</option>
                    </select>
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.temu-dokter.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
