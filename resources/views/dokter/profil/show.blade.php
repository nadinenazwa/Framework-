@extends('layouts.lte.main')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1"><i class="bi bi-person-badge"></i> Profil Dokter</h2>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('dokter.profil.edit') }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Profil
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Nama</th>
                    <td>{{ Auth::user()->nama }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ Auth::user()->email }}</td>
                </tr>
                <tr>
                    <th>Bidang</th>
                    <td>{{ $dokter->bidang_dokter ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $dokter->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $dokter->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $dokter->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
