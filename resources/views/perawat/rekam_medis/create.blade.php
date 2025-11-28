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

                <!-- Patient Selection: Only patients with 'menunggu' appointment -->
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
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->pet->idpet }}"
                                    data-appointment="{{ $appointment->idtemu_dokter }}"
                                    data-pet="{{ $appointment->pet->nama_hewan ?? '-' }}"
                                    data-ras="{{ $appointment->pet->rasHewan->nama_ras ?? '-' }}"
                                    data-jenis="{{ $appointment->pet->jenisHewan->nama_jenis_hewan ?? '-' }}"
                                    data-pemilik="{{ $appointment->pet->pemilik->nama_pemilik ?? '-' }}"
                                    data-hp="{{ $appointment->pet->pemilik->no_hp ?? '-' }}"
                                    data-email="{{ $appointment->pet->pemilik->user->email ?? '-' }}"
                                    data-dokter="{{ $appointment->roleUser->user->name ?? '-' }}"
                                    data-dokterid="{{ $appointment->roleUser->idrole_user ?? '' }}"
                                    data-waktu="{{ date('d/m/Y H:i', strtotime($appointment->waktu_daftar)) }}">
                                    {{ $appointment->pet->nama_hewan ?? '-' }} ({{ $appointment->pet->rasHewan->nama_ras ?? '-' }}) - {{ $appointment->pet->pemilik->nama_pemilik ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('idpet')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Hanya pasien yang punya temu dokter status <b>menunggu</b> yang bisa dibuat rekam medis.
                        </small>
                    </div>
                </div>

                <!-- Auto-filled Info: Jadwal, Pasien, Pemilik, Dokter -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-info-circle"></i> Informasi Temu Dokter & Pasien (Otomatis)
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jadwal Temu Dokter</label>
                            <input type="text" id="jadwal_temu" class="form-control bg-white" value="-" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dokter Pemeriksa</label>
                            <input type="text" id="dokter_pemeriksa_nama" class="form-control bg-white" value="-" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pasien (Hewan)</label>
                            <input type="text" id="nama_hewan" class="form-control bg-white" value="-" readonly>
                            <small class="text-muted">Jenis: <span id="jenis_hewan">-</span></small><br>
                            <small class="text-muted">Ras: <span id="ras_hewan">-</span></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pemilik</label>
                            <input type="text" id="nama_pemilik" class="form-control bg-white" value="-" readonly>
                            <small class="text-muted">No. HP: <span id="hp_pemilik">-</span></small><br>
                            <small class="text-muted">Email: <span id="email_pemilik">-</span></small>
                        </div>
                    </div>
                    <!-- Hidden fields for submission -->
                    <input type="hidden" name="idreservasi_dokter" id="idreservasi_dokter_hidden">
                    <input type="hidden" name="dokter_pemeriksa" id="dokter_pemeriksa_hidden">
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

                <!-- ...otomatis, tidak ada select dokter/temu dokter manual... -->

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
        const pasienSelect = document.getElementById('idpet');
        const jadwalTemu = document.getElementById('jadwal_temu');
        const namaHewan = document.getElementById('nama_hewan');
        const jenisHewan = document.getElementById('jenis_hewan');
        const rasHewan = document.getElementById('ras_hewan');
        const namaPemilik = document.getElementById('nama_pemilik');
        const hpPemilik = document.getElementById('hp_pemilik');
        const emailPemilik = document.getElementById('email_pemilik');
        const dokterPemeriksaNama = document.getElementById('dokter_pemeriksa_nama');
        const idreservasiHidden = document.getElementById('idreservasi_dokter_hidden');
        const dokterPemeriksaHidden = document.getElementById('dokter_pemeriksa_hidden');

        pasienSelect.addEventListener('change', function() {
            const selected = pasienSelect.options[pasienSelect.selectedIndex];
            jadwalTemu.value = selected.getAttribute('data-waktu') || '-';
            namaHewan.value = selected.getAttribute('data-pet') || '-';
            jenisHewan.textContent = selected.getAttribute('data-jenis') || '-';
            rasHewan.textContent = selected.getAttribute('data-ras') || '-';
            namaPemilik.value = selected.getAttribute('data-pemilik') || '-';
            hpPemilik.textContent = selected.getAttribute('data-hp') || '-';
            emailPemilik.textContent = selected.getAttribute('data-email') || '-';
            dokterPemeriksaNama.value = selected.getAttribute('data-dokter') || '-';
            idreservasiHidden.value = selected.getAttribute('data-appointment') || '';
            dokterPemeriksaHidden.value = selected.getAttribute('data-dokterid') || '';
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
