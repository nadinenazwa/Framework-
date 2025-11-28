@extends('layouts.lte.main')

@section('title', 'Edit Perawat')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header"><h3 class="card-title">Edit Perawat</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.perawat.update', $perawat->id_perawat) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <input type="text" class="form-control" value="{{ $perawat->user->nama ?? '-' }} ({{ $perawat->user->email ?? '-' }})" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pendidikan</label>
                    <input type="text" name="pendidikan" class="form-control" value="{{ $perawat->pendidikan }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="L" @if($perawat->jenis_kelamin=='L') selected @endif>Laki-laki</option>
                        <option value="P" @if($perawat->jenis_kelamin=='P') selected @endif>Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telp</label>
                    <input type="text" name="no_telp" class="form-control" value="{{ $perawat->no_telp }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" required>{{ $perawat->alamat }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.perawat.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
