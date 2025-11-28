@extends('layouts.lte.main')

@section('title', 'Edit Profil Dokter')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1"><i class="bi bi-person-badge"></i> Edit Profil Dokter</h2>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dokter.profil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', Auth::user()->nama) }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>
                <div class="mb-3">
                    <label for="bidang_dokter" class="form-label">Bidang</label>
                    <input type="text" class="form-control" id="bidang_dokter" name="bidang_dokter" value="{{ old('bidang_dokter', $dokter->bidang_dokter) }}">
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $dokter->alamat) }}">
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="L" {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('dokter.profil.show') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
