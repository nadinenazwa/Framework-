@extends('layouts.lte.main')

@section('title', 'Detail Pemilik - ' . ($pemilik->nama_pemilik ?? 'Pemilik'))

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.pemilik.index') }}">Pemilik</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pemilik->nama_pemilik ?? '-' }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-person"></i> Detail Pemilik
            </h2>
            <p class="text-muted">Informasi lengkap pemilik hewan peliharaan</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group" role="group">
                <a href="{{ route('resepsionis.pemilik.edit', $pemilik->idpemilik) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-secondary">
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

    <!-- Personal Information Card -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person"></i> Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Nama:</dt>
                        <dd class="col-sm-7">
                            <strong>{{ $pemilik->nama_pemilik ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">No. HP:</dt>
                        <dd class="col-sm-7">
                            <a href="tel:{{ $pemilik->no_hp ?? '#' }}">
                                {{ $pemilik->no_hp ?? '-' }}
                            </a>
                        </dd>

                        <dt class="col-sm-5">Alamat:</dt>
                        <dd class="col-sm-7">
                            <small>{{ $pemilik->alamat ?? '-' }}</small>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lock"></i> Informasi Akun
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7">
                            <a href="mailto:{{ $pemilik->user->email ?? '#' }}">
                                {{ $pemilik->user->email ?? '-' }}
                            </a>
                        </dd>

                        <dt class="col-sm-5">Status Akun:</dt>
                        <dd class="col-sm-7">
                            @if($pemilik->user->email_verified_at)
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-warning">Belum Terverifikasi</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Terdaftar:</dt>
                        <dd class="col-sm-7">
                            {{ $pemilik->user->created_at ? $pemilik->user->created_at->format('d/m/Y') : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pet List Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-paw"></i> Daftar Hewan Peliharaan
            </h5>
        </div>
        <div class="card-body">
            @if($pemilik->pet->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="col-2">Nama Hewan</th>
                                <th class="col-2">Jenis</th>
                                <th class="col-2">Ras</th>
                                <th class="col-2">Warna</th>
                                <th class="col-2">Berat</th>
                                <th class="col-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemilik->pet as $pet)
                                <tr>
                                    <td><strong>{{ $pet->nama_hewan ?? '-' }}</strong></td>
                                    <td>{{ $pet->jenisHewan->nama_jenis_hewan ?? '-' }}</td>
                                    <td>{{ $pet->rasHewan->nama_ras ?? '-' }}</td>
                                    <td>{{ $pet->warna ?? '-' }}</td>
                                    <td>{{ $pet->berat_badan ?? '-' }} kg</td>
                                    <td>
                                        <a href="{{ route('resepsionis.pet.show', $pet->idpet) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> Pemilik ini belum memiliki hewan peliharaan terdaftar.
                </div>
            @endif
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
                <dt class="col-sm-3">ID Pemilik:</dt>
                <dd class="col-sm-9">
                    <code>{{ $pemilik->idpemilik }}</code>
                </dd>

                <dt class="col-sm-3">ID User:</dt>
                <dd class="col-sm-9">
                    <code>{{ $pemilik->iduser }}</code>
                </dd>

                <dt class="col-sm-3">Dibuat pada:</dt>
                <dd class="col-sm-9">
                    {{ $pemilik->created_at ? $pemilik->created_at->format('d/m/Y H:i:s') : '-' }}
                </dd>

                <dt class="col-sm-3">Terakhir diperbarui:</dt>
                <dd class="col-sm-9">
                    {{ $pemilik->updated_at ? $pemilik->updated_at->format('d/m/Y H:i:s') : '-' }}
                </dd>
            </dl>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="mt-4">
        <button type="button" class="btn btn-danger btn-lg" 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal">
            <i class="bi bi-trash"></i> Hapus Pemilik Ini
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
                        <p><strong>Peringatan:</strong> Penghapusan ini juga akan menghapus akun pengguna terkait.</p>
                        <p>Apakah Anda yakin ingin menghapus pemilik ini?</p>
                        <div class="bg-light p-3 rounded">
                            <strong>Nama:</strong> {{ $pemilik->nama_pemilik ?? '-' }}<br>
                            <strong>Email:</strong> {{ $pemilik->user->email ?? '-' }}<br>
                            <strong>Hewan:</strong> {{ $pemilik->pet->count() ?? 0 }} hewan terdaftar
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('resepsionis.pemilik.destroy', $pemilik->idpemilik) }}" method="POST" class="d-inline">
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
