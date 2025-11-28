@extends('layouts.lte.main')

@section('title', 'Tambah Perawat')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header"><h3 class="card-title">Tambah Perawat</h3></div>
        <div class="card-body">
            <form action="{{ route('admin.perawat.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="iduser" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->iduser }}">{{ $user->nama }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pendidikan</label>
                    <input type="text" name="pendidikan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telp</label>
                    <input type="text" name="no_telp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.perawat.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
