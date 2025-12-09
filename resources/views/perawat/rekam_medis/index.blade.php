@extends('layouts.lte.main')

@section('title', 'Daftar Semua Pasien')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Pasien</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-list-ul"></i> Daftar Semua Pasien
            </h2>
            <p class="text-muted">Lihat riwayat rekam medis semua pasien</p>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-table"></i> Data Pasien (Pet)
            </h5>
        </div>
        <div class="card-body">
            @if($semuaPasien->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="col-1"><i class="bi bi-hash"></i> ID</th>
                                <th class="col-2"><i class="bi bi-paw"></i> Nama Pasien</th>
                                <th class="col-2"><i class="bi bi-diagram-3"></i> Jenis</th>
                                <th class="col-2"><i class="bi bi-tag"></i> Ras</th>
                                <th class="col-2"><i class="bi bi-person"></i> Pemilik</th>
                                <th class="col-2"><i class="bi bi-gear"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semuaPasien as $pasien)
                            <tr>
                                <td class="fw-bold">{{ $pasien->idpet }}</td>
                                <td><strong>{{ $pasien->nama }}</strong></td>
                                <td>{{ $pasien->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</td>
                                <td>{{ $pasien->rasHewan->nama_ras ?? '-' }}</td>
                                <td>{{ $pasien->pemilik->user->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('perawat.pasien.show', $pasien->idpet) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Lihat Rekam Medis
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-info-circle" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3">Belum Ada Data Pasien</h5>
                    <p class="mb-3">Tidak ada pasien yang terdaftar dalam sistem.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection