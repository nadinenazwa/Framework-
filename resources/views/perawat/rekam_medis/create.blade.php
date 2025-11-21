@extends('layouts.lte.main')

@section('title', 'Tambah Rekam Medis')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.index') }}">Rekam Medis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-file-earmark-medical"></i> Tambah Rekam Medis Baru
            </h2>
            <p class="text-muted">Buat rekam medis baru untuk pasien (hewan)</p>
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
                <i class="bi bi-clipboard-check"></i> Form Rekam Medis
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('perawat.rekam-medis.store') }}" method="POST" id="rekamMedisForm">
                @csrf

                <!-- Patient Selection -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-paw"></i> Pilih Pasien (Hewan)
                    </h6>
                    <div class="mb-3">
                        <label for="idpet" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Pasien (Hewan)
                        </label>
                        <select name="idpet" id="idpet" class="form-select @error('idpet') is-invalid @enderror" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($pets as $pet)
                                <option value="{{ $pet->idpet }}" @selected(old('idpet') == $pet->idpet)>
                                    {{ $pet->nama_hewan }} ({{ $pet->rasHewan->nama_ras ?? '-' }}) - 
                                    {{ $pet->pemilik->nama_pemilik ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('idpet')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Pilih hewan peliharaan yang akan dibuat rekam medisnya
                        </small>
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
                                  rows="3" required placeholder="Ceritakan keluhan/gejala pasien...">{{ old('anamnesa') }}</textarea>
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
                                  rows="3" required placeholder="Hasil pemeriksaan klinis pasien...">{{ old('temuan_klinis') }}</textarea>
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
                                  rows="3" required placeholder="Diagnosis berdasarkan pemeriksaan...">{{ old('diagnosa') }}</textarea>
                        @error('diagnosa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Diagnosis yang ditetapkan berdasarkan anamnesis dan temuan klinis
                        </small>
                    </div>
                </div>

                <!-- Doctor and Appointment -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 class="mb-3">
                                <i class="bi bi-person-badge"></i> Dokter Pemeriksa
                            </h6>
                            <div class="mb-0">
                                <label for="dokter_pemeriksa" class="form-label">
                                    <span class="badge bg-danger">Wajib</span> Dokter
                                </label>
                                <select name="dokter_pemeriksa" id="dokter_pemeriksa" class="form-select @error('dokter_pemeriksa') is-invalid @enderror" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->idrole_user }}" @selected(old('dokter_pemeriksa') == $doctor->idrole_user)>
                                            {{ $doctor->user->name ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dokter_pemeriksa')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted d-block mt-2">
                                    Dokter yang melakukan pemeriksaan
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 class="mb-3">
                                <i class="bi bi-calendar-event"></i> Jadwal Temu Dokter
                            </h6>
                            <div class="mb-0">
                                <label for="idreservasi_dokter" class="form-label">
                                    <span class="badge bg-danger">Wajib</span> Temu Dokter
                                </label>
                                <select name="idreservasi_dokter" id="idreservasi_dokter" class="form-select @error('idreservasi_dokter') is-invalid @enderror" required>
                                    <option value="">-- Pilih Temu Dokter --</option>
                                    @foreach($appointments as $appointment)
                                        <option value="{{ $appointment->idtemu_dokter }}" @selected(old('idreservasi_dokter') == $appointment->idtemu_dokter)>
                                            {{ date('d/m/Y H:i', strtotime($appointment->waktu_daftar)) }} - 
                                            {{ $appointment->pet->nama_hewan ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idreservasi_dokter')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted d-block mt-2">
                                    Jadwal temu dokter yang sudah di-booking
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rekamMedisForm');
        
        // Update appointment options based on selected pet
        const petSelect = document.getElementById('idpet');
        const appointmentSelect = document.getElementById('idreservasi_dokter');
        
        petSelect.addEventListener('change', function() {
            // In a real scenario, you'd filter appointments by selected pet via AJAX
            // For now, the backend handles this in the create() method
        });

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
