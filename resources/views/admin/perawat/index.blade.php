@extends('layouts.lte.main')

@section('title', 'Data Perawat')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Perawat</h3>
            <a href="{{ route('admin.perawat.create') }}" class="btn btn-primary btn-sm">Tambah Perawat</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pendidikan</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $perawat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $perawat->user->nama ?? '-' }}</td>
                        <td>{{ $perawat->user->email ?? '-' }}</td>
                        <td>{{ $perawat->pendidikan }}</td>
                        <td>{{ $perawat->alamat }}</td>
                        <td>{{ $perawat->no_hp }}</td>
                        <td>{{ $perawat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>
                            <a href="{{ route('admin.perawat.edit', $perawat->id_perawat) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.perawat.destroy', $perawat->id_perawat) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin hapus data?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data perawat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
