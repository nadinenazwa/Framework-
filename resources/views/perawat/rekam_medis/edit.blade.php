@extends('layouts.lte.main')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="container-fluid">
    @php
        $pet = $rekamMedis->pet ?? ($rekamMedis->temuDokter->pet ?? null);
    @endphp
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.antrian.index') }}">Daftar Temu Dokter</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.show', $rekamMedis) }}">
                {{ $pet->nama ?? '-' }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-pencil-square"></i> Edit Rekam Medis
            </h2>
            <p class="text-muted">Perbarui informasi rekam medis</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">
                <i class="bi bi-exclamation-triangle"></i> Validation Error!
            </h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-check"></i> Form Edit Rekam Medis
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('perawat.rekam-medis.update', $rekamMedis->idrekam_medis) }}" method="POST" id="rekamMedisForm">
                @csrf
                @method('PUT')

                <!-- Patient Information (Read-only) -->
                @php
                    $pet = $rekamMedis->pet ?? ($rekamMedis->temuDokter->pet ?? null);
                    $owner = $pet?->pemilik ?? null;
                @endphp
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-paw"></i> Informasi Pasien
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pasien (Hewan)</label>
                            <div class="form-control bg-white" readonly>
                                <strong>{{ $pet->nama ?? '-' }}</strong>
                                <br>
                                <small class="text-muted">Jenis: {{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</small>
                                <br>
                                <small class="text-muted">Ras: {{ $pet->rasHewan->nama_ras ?? '-' }}</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pemilik</label>
                            <div class="form-control bg-white" readonly>
                                <strong>{{ $owner->user->nama ?? '-' }}</strong>
                                <br>
                                <small class="text-muted">No. HP: {{ $owner->no_wa ?? '-' }}</small>
                                <br>
                                <small class="text-muted">Email: {{ $owner->user->email ?? '-' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clinical Information -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-stethoscope"></i> Informasi Klinis
                    </h6>

                    <!-- Anamnesis -->
                    <div class="mb-3">
                        <label for="anamnesa" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Anamnesis
                        </label>
                        <textarea name="anamnesa" id="anamnesa" class="form-control @error('anamnesa') is-invalid @enderror" 
                                  rows="3" required placeholder="Ceritakan keluhan/gejala pasien...">{{ old('anamnesa', $rekamMedis->anamnesa) }}</textarea>
                        @error('anamnesa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Jelaskan keluhan utama, durasi, dan gejala yang dirasakan hewan peliharaan
                        </small>
                    </div>

                    <!-- Clinical Findings -->
                    <div class="mb-3">
                        <label for="temuan_klinis" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Temuan Klinis
                        </label>
                        <textarea name="temuan_klinis" id="temuan_klinis" class="form-control @error('temuan_klinis') is-invalid @enderror" 
                                  rows="3" required placeholder="Hasil pemeriksaan klinis pasien...">{{ old('temuan_klinis', $rekamMedis->temuan_klinis) }}</textarea>
                        @error('temuan_klinis')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Hasil dari pemeriksaan fisik dan klinis pasien
                        </small>
                    </div>

                    <!-- Diagnosis -->
                    <div class="mb-3">
                        <label for="diagnosa" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Diagnosis
                        </label>
                        <textarea name="diagnosa" id="diagnosa" class="form-control @error('diagnosa') is-invalid @enderror" 
                                  rows="3" required placeholder="Diagnosis berdasarkan pemeriksaan...">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                        @error('diagnosa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Diagnosis yang ditetapkan berdasarkan anamnesis dan temuan klinis
                        </small>
                    </div>
                </div>

                <!-- ...removed Dokter Pemeriksa and Jadwal Temu Dokter fields for perawat... -->

                <!-- Form Actions -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('perawat.rekam-medis.show', $rekamMedis->idrekam_medis) }}" class="btn btn-secondary btn-lg me-2">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Perbarui
                    </button>
                </div>
            </form>

            <div class="mt-3">
                <form action="{{ route('perawat.rekam-medis.destroy', $rekamMedis->idrekam_medis) }}" method="POST" onsubmit="return confirm('Hapus rekam medis ini? Tindakan ini akan melakukan soft delete.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus Rekam (Soft Delete)
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rekamMedisForm');

        // Form validation
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
@endsection
