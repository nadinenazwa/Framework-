@extends('layouts.lte.main')

@section('title', 'Edit Temu Dokter - Admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Edit Temu Dokter</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.temu-dokter.update', $temuDokter->idreservasi_dokter) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Pet</label>
                    <select name="idpet" class="form-control">
                        <option value="">Pilih Pet</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->idpet }}" {{ $pet->idpet == $temuDokter->idpet ? 'selected' : '' }}>{{ $pet->nama }} - {{ optional($pet->pemilik)->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokter <span class="text-danger">*</span></label>
                    <select name="idrole_user" class="form-control" required>
                        <option value="">Pilih Dokter</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->idrole_user }}" {{ $d->idrole_user == $temuDokter->idrole_user ? 'selected' : '' }}>{{ optional($d->user)->nama }}</option>
                        @endforeach
                    </select>
                    @error('idrole_user')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="1" {{ $temuDokter->status == '1' ? 'selected' : '' }}>Menunggu</option>
                        <option value="2" {{ $temuDokter->status == '2' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">No Urut</label>
                    <input type="number" name="no_urut" class="form-control" value="{{ $temuDokter->no_urut }}">
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.temu-dokter.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
