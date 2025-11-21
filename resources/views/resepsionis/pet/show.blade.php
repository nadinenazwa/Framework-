@extends('layouts.lte.main')

@section('title', 'Detail Hewan Peliharaan - ' . ($pet->nama_hewan ?? 'Hewan'))

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Hewan Peliharaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pet->nama_hewan ?? '-' }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-paw"></i> Detail Hewan Peliharaan
            </h2>
            <p class="text-muted">Informasi lengkap hewan peliharaan</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group" role="group">
                <a href="{{ route('resepsionis.pet.edit', $pet->idpet) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Pet Information Card -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-paw"></i> Informasi Hewan Peliharaan
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Nama Hewan:</dt>
                        <dd class="col-sm-7">
                            <strong>{{ $pet->nama_hewan ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">Jenis Hewan:</dt>
                        <dd class="col-sm-7">
                            {{ $pet->jenisHewan->nama_jenis_hewan ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Ras Hewan:</dt>
                        <dd class="col-sm-7">
                            {{ $pet->rasHewan->nama_ras ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Warna:</dt>
                        <dd class="col-sm-7">
                            {{ $pet->warna ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Umur:</dt>
                        <dd class="col-sm-7">
                            {{ $pet->umur ?? '-' }} tahun
                        </dd>

                        <dt class="col-sm-5">Berat Badan:</dt>
                        <dd class="col-sm-7">
                            {{ $pet->berat_badan ?? '-' }} kg
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person"></i> Informasi Pemilik
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Nama:</dt>
                        <dd class="col-sm-7">
                            <strong>{{ $pet->pemilik->nama_pemilik ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">No. HP:</dt>
                        <dd class="col-sm-7">
                            <a href="tel:{{ $pet->pemilik->no_hp ?? '#' }}">
                                {{ $pet->pemilik->no_hp ?? '-' }}
                            </a>
                        </dd>

                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7">
                            <a href="mailto:{{ $pet->pemilik->user->email ?? '#' }}">
                                {{ $pet->pemilik->user->email ?? '-' }}
                            </a>
                        </dd>

                        <dt class="col-sm-5">Alamat:</dt>
                        <dd class="col-sm-7">
                            <small>{{ $pet->pemilik->alamat ?? '-' }}</small>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Metadata Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">
                <i class="bi bi-info-circle"></i> Informasi Sistem
            </h5>
        </div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID Hewan Peliharaan:</dt>
                <dd class="col-sm-9">
                    <code>{{ $pet->idpet }}</code>
                </dd>

                <dt class="col-sm-3">Dibuat pada:</dt>
                <dd class="col-sm-9">
                    {{ $pet->created_at ? $pet->created_at->format('d/m/Y H:i:s') : '-' }}
                </dd>

                <dt class="col-sm-3">Terakhir diperbarui:</dt>
                <dd class="col-sm-9">
                    {{ $pet->updated_at ? $pet->updated_at->format('d/m/Y H:i:s') : '-' }}
                </dd>
            </dl>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="mt-4">
        <button type="button" class="btn btn-danger btn-lg" 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal">
            <i class="bi bi-trash"></i> Hapus Hewan Ini
        </button>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">
                            <i class="bi bi-exclamation-triangle"></i> Konfirmasi Penghapusan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus hewan peliharaan ini?</p>
                        <div class="bg-light p-3 rounded">
                            <strong>Nama Hewan:</strong> {{ $pet->nama_hewan ?? '-' }}<br>
                            <strong>Pemilik:</strong> {{ $pet->pemilik->nama_pemilik ?? '-' }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('resepsionis.pet.destroy', $pet->idpet) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            }
        });
    });
</script>
@endsection
