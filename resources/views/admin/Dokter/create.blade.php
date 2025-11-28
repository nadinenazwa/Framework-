@extends('layouts.lte.main')

@section('title', 'Tambah Dokter')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Dokter</h3>
    </div>
    <form action="{{ route('admin.dokter.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group mb-3">
                <label>Pilih User (Akun)</label>
                <select name="iduser" class="form-control @error('iduser') is-invalid @enderror">
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->iduser }}">{{ $u->nama }} ({{ $u->email }})</option>
                    @endforeach
                </select>
                @error('iduser') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Bidang Dokter</label>
                <input type="text" name="bidang_dokter" class="form-control @error('bidang_dokter') is-invalid @enderror" value="{{ old('bidang_dokter') }}" placeholder="Contoh: Umum, Bedah, Gigi">
                @error('bidang_dokter') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection