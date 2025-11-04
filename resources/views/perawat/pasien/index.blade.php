@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Daftar Pasien</h1>
            <a href="{{ route('perawat.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Semua Data Pasien (Pet)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Pasien (Pet)</th>
                                    <th>Jenis Hewan</th>
                                    <th>Ras</th>
                                    <th>Pemilik</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($semuaPasien as $pasien)
                                <tr>
                                    <td>{{ $pasien->nama }}</td>
                                    <td>{{ $pasien->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</td>
                                    <td>{{ $pasien->rasHewan->nama_ras ?? 'N/A' }}</td>
                                    <td>{{ $pasien->pemilik->user->nama ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('perawat.pasien.show', $pasien->idpet) }}" class="btn btn-info btn-sm">
                                            Lihat Rekam Medis
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data pasien tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection