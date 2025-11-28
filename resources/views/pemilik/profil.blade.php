@extends('layouts.lte.main')

@section('title', 'Profil Pemilik')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-person"></i> Profil Pemilik
            </h2>
            <p class="text-muted">Informasi profil dan data pet Anda</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('pemilik.profil.edit') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-pencil"></i> Edit Profil
            </a>
        </div>
    </div>

    <!-- Profil Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-card-text"></i> Informasi Profil
            </h5>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ Auth::user()->nama }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>No. WA:</strong> {{ Auth::user()->pemilik->no_wa }}</p>
            <p><strong>Alamat:</strong> {{ Auth::user()->pemilik->alamat }}</p>
        </div>
    </div>

    <!-- Daftar Pet -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-list"></i> Daftar Pet Anda
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pet</th>
                            <th>Jenis Hewan</th>
                            <th>Ras</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->pemilik->pets as $index => $pet)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pet->nama }}</td>
                            <td>{{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</td>
                            <td>{{ $pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                            <td>{{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Anda belum mendaftarkan pet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection