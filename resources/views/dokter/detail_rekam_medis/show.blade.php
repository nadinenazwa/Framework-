@extends('layouts.lte.main')

@section('title', 'Detail Tindakan/Terapi')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.detail-rekam-medis.index') }}">Detail Rekam Medis</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $detailRekamMedis->iddetail_rekam_medis }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-file-medical"></i> Detail Tindakan/Terapi
            </h2>
            <p class="text-muted">Informasi lengkap tindakan dan terapi pasien</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group" role="group">
                <a href="{{ route('dokter.detail_rekam_medis.edit', $detailRekamMedis->iddetail_rekam_medis) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('dokter.detail-rekam-medis.index') }}" class="btn btn-secondary">
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

    <!-- Medical Record Information Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-paw"></i> Informasi Pasien
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Nama Hewan:</dt>
                        <dd class="col-sm-7">
                            <strong>{{ $detailRekamMedis->rekamMedis->pet->nama_hewan ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">Jenis:</dt>
                        <dd class="col-sm-7">
                            {{ $detailRekamMedis->rekamMedis->pet->jenisHewan->nama_jenis_hewan ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Ras:</dt>
                        <dd class="col-sm-7">
                            {{ $detailRekamMedis->rekamMedis->pet->rasHewan->nama_ras ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Berat:</dt>
                        <dd class="col-sm-7">
                            {{ $detailRekamMedis->rekamMedis->pet->berat_badan ?? '-' }} kg
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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
                            <strong>{{ $detailRekamMedis->rekamMedis->pet->pemilik->nama_pemilik ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">No. HP:</dt>
                        <dd class="col-sm-7">
                            {{ $detailRekamMedis->rekamMedis->pet->pemilik->no_hp ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7">
                            <small>{{ $detailRekamMedis->rekamMedis->pet->pemilik->user->email ?? '-' }}</small>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-stethoscope"></i> Diagnosis
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        {{ $detailRekamMedis->rekamMedis->diagnosa ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Treatment Information Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-check"></i> Informasi Tindakan/Terapi
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-code-square"></i> Kode Tindakan/Terapi
                    </h6>
                    <dl class="row">
                        <dt class="col-sm-5">Nama:</dt>
                        <dd class="col-sm-7">
                            <strong>{{ $detailRekamMedis->tindakanTerapi->nama_kode_tindakan ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">Kategori:</dt>
                        <dd class="col-sm-7">
                            {{ $detailRekamMedis->tindakanTerapi->kategori->nama_kategori_klinis ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">ID:</dt>
                        <dd class="col-sm-7">
                            <code>{{ $detailRekamMedis->idkode_tindakan_terapi }}</code>
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-calendar-event"></i> Informasi Rekam Medis
                    </h6>
                    <dl class="row">
                        <dt class="col-sm-5">ID Rekam Medis:</dt>
                        <dd class="col-sm-7">
                            <code>{{ $detailRekamMedis->idrekam_medis }}</code>
                        </dd>

                        <dt class="col-sm-5">Dokter:</dt>
                        <dd class="col-sm-7">
                            {{ $detailRekamMedis->rekamMedis->dokterPemeriksa->user->name ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Tanggal Periksa:</dt>
                        <dd class="col-sm-7">
                            {{ $detailRekamMedis->rekamMedis->temuDokter->waktu_daftar ? date('d/m/Y', strtotime($detailRekamMedis->rekamMedis->temuDokter->waktu_daftar)) : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Description Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="bi bi-file-text"></i> Keterangan Detail
            </h5>
        </div>
        <div class="card-body">
            <p class="card bg-light p-4 rounded">
                {{ $detailRekamMedis->detail ?? '-' }}
            </p>
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
                <dt class="col-sm-3">ID Detail Rekam Medis:</dt>
                <dd class="col-sm-9">
                    <code>{{ $detailRekamMedis->iddetail_rekam_medis }}</code>
                </dd>

                <dt class="col-sm-3">Dibuat pada:</dt>
                <dd class="col-sm-9">
                    {{ $detailRekamMedis->created_at ? $detailRekamMedis->created_at->format('d/m/Y H:i:s') : '-' }}
                </dd>

                <dt class="col-sm-3">Terakhir diperbarui:</dt>
                <dd class="col-sm-9">
                    {{ $detailRekamMedis->updated_at ? $detailRekamMedis->updated_at->format('d/m/Y H:i:s') : '-' }}
                </dd>
            </dl>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="mt-4">
        <button type="button" class="btn btn-danger btn-lg" 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal">
            <i class="bi bi-trash"></i> Hapus Detail Ini
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
                        <p>Apakah Anda yakin ingin menghapus detail rekam medis ini?</p>
                        <div class="bg-light p-3 rounded">
                            <strong>Pasien:</strong> {{ $detailRekamMedis->rekamMedis->pet->nama_hewan ?? '-' }}<br>
                            <strong>Tindakan:</strong> {{ $detailRekamMedis->tindakanTerapi->nama_kode_tindakan ?? '-' }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('dokter.detail_rekam_medis.destroy', $detailRekamMedis->iddetail_rekam_medis) }}" method="POST" class="d-inline">
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
