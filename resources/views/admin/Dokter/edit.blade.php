@extends('layouts.lte.main')

@section('title', 'Edit Dokter')

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Form Edit Dokter</h3>
    </div>
    <form action="{{ route('admin.dokter.update', $dokter->id_dokter) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            {{-- Dropdown Nama Akun (Hanya User dengan Role Dokter) --}}
            <div class="form-group mb-3">
                <label>Nama Akun</label>
                <select name="iduser" class="form-control @error('iduser') is-invalid @enderror">
                    <option value="">-- Pilih Akun --</option>
                    @foreach($user as $u)
                        <option value="{{ $u->iduser }}" {{ old('iduser', $dokter->iduser) == $u->iduser ? 'selected' : '' }}>
                            {{ $u->nama }} ({{ $u->email }})
                        </option>
                    @endforeach
                </select>
                @error('iduser') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Bidang Dokter</label>
                <input type="text" name="bidang_dokter" class="form-control @error('bidang_dokter') is-invalid @enderror" value="{{ old('bidang_dokter', $dokter->bidang_dokter) }}">
                @error('bidang_dokter') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                    <option value="L" {{ $dokter->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $dokter->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $dokter->no_hp) }}">
                @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $dokter->alamat) }}</textarea>
                @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection