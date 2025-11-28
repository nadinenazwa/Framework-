@extends('layouts.lte.main')

@section('title', 'Daftar Rekam Medis')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekam Medis</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-file-medical"></i> Daftar Rekam Medis
            </h2>
            <p class="text-muted">Kelola rekam medis pasien (hewan)</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Tambah Rekam Medis
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">
                <i class="bi bi-exclamation-triangle"></i> Terjadi Kesalahan!
            </h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-table"></i> Data Rekam Medis
            </h5>
        </div>
        <div class="card-body">
            @if($rekamMedis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="col-1">
                                    <i class="bi bi-hash"></i> ID
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-paw"></i> Pasien (Hewan)<br><small>ID Pet</small>
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-person"></i> Pemilik<br><small>ID Pemilik</small>
                                </th>
                                <th class="col-1">
                                    <i class="bi bi-calendar-event"></i> Temu Dokter
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-stethoscope"></i> Dokter
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-file-text"></i> Diagnosis
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-gear"></i> Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekamMedis as $medis)
                                <tr>
                                    <td class="fw-bold">{{ $medis->idrekam_medis }}</td>
                                    <td>
                                        <strong>{{ $medis->temuDokter->pet->nama ?? '-' }}</strong><br>
                                        <small class="text-muted">
                                            {{ $medis->temuDokter->pet->rasHewan->nama_ras ?? '-' }}
                                        </small><br>
                                        <span class="badge bg-secondary">idpet: {{ $medis->temuDokter->pet->idpet ?? '-' }}</span>
                                    </td>
                                    <td>
                                        {{ $medis->temuDokter->pet->pemilik->user->nama ?? '-' }}<br>
                                        <small class="text-muted">
                                            {{ $medis->temuDokter->pet->pemilik->user->email ?? '-' }}
                                        </small><br>
                                        <span class="badge bg-secondary">idpemilik: {{ $medis->temuDokter->pet->pemilik->idpemilik ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if($medis->temuDokter)
                                            <span class="badge bg-info">
                                                {{ date('d/m/Y', strtotime($medis->temuDokter->waktu_daftar)) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $medis->dokterPemeriksa->user->nama ?? '-' }}
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($medis->diagnosa, 50) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('perawat.rekam-medis.show', $medis->idrekam_medis) }}" 
                                               class="btn btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('perawat.rekam-medis.edit', $medis->idrekam_medis) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $medis->idrekam_medis }}"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $medis->idrekam_medis }}" 
                                             tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel">
                                                            <i class="bi bi-exclamation-triangle"></i> Konfirmasi Penghapusan
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" 
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus rekam medis ini?</p>
                                                        <p class="text-danger small">
                                                            <strong>Peringatan:</strong> Penghapusan ini juga akan menghapus semua detail rekam medis yang terkait.
                                                        </p>
                                                        <div class="bg-light p-3 rounded">
                                                            <strong>Pasien:</strong> {{ $medis->pet->nama_hewan ?? '-' }}<br>
                                                            <strong>Pemilik:</strong> {{ $medis->pet->pemilik->nama_pemilik ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" 
                                                                data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('perawat.rekam-medis.destroy', $medis->idrekam_medis) }}" 
                                                              method="POST" class="d-inline">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $rekamMedis->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-info-circle" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3">Belum Ada Data Rekam Medis</h5>
                    <p class="mb-3">Tidak ada rekam medis yang tersimpan dalam sistem.</p>
                    <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Rekam Medis Pertama
                    </a>
                </div>
            @endif
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
