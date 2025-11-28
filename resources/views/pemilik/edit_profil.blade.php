@extends('layouts.lte.main')

@section('title', 'Edit Profil Pemilik')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pemilik.profil') }}">Profil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-pencil"></i> Edit Profil Pemilik
            </h2>
            <p class="text-muted">Perbarui informasi profil Anda</p>
        </div>
    </div>

    <!-- Form Edit Profil -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-card-text"></i> Form Edit Profil
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pemilik.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', Auth::user()->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="no_wa" class="form-label">No. WA</label>
                    <input type="text" name="no_wa" id="no_wa" class="form-control" value="{{ old('no_wa', $pemilik->no_wa) }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection