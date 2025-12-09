@extends('layouts.lte.main')

@section('title', 'Tambah Rekam Medis')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.antrian.index') }}">Daftar Temu Dokter</a></li>
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

                <!-- Patient selection or readonly appointment -->
                @if(isset($appointment))
                    <div class="mb-4 p-3 border rounded bg-light">
                        <h6 class="mb-3"><i class="bi bi-paw"></i> Pasien (dari Temu Dokter)</h6>
                        <div>
                            <strong>{{ $appointment->pet->nama ?? '-' }}</strong>
                            <div class="text-muted">{{ $appointment->pet->rasHewan->nama_ras ?? '-' }} &bull; Pemilik: {{ optional($appointment->pet->pemilik->user)->nama ?? '-' }}</div>
                        </div>
                        {{-- Hidden submission fields --}}
                        <input type="hidden" name="idpet" value="{{ $appointment->pet->idpet ?? '' }}">
                        <input type="hidden" name="idreservasi_dokter" id="idreservasi_dokter_hidden" value="{{ $appointment->idreservasi_dokter ?? '' }}">
                        <input type="hidden" name="dokter_pemeriksa" id="dokter_pemeriksa_hidden" value="{{ $appointment->roleUser->idrole_user ?? '' }}">
                    </div>
                @else
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
                                    @php $apptId = $appointment->idreservasi_dokter ?? $appointment->id ?? null; @endphp
                                    <option value="{{ $appointment->pet->idpet }}" data-appointment="{{ $apptId }}" data-dokterid="{{ $appointment->roleUser->idrole_user ?? '' }}">
                                        {{ $appointment->pet->nama ?? '-' }} ({{ $appointment->pet->rasHewan->nama_ras ?? '-' }}) - {{ $appointment->pet->pemilik->user->nama ?? '-' }}
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
                @endif

                <!-- Hidden fields for submission (TemuDokter & Dokter) -->
                <input type="hidden" name="idreservasi_dokter" id="idreservasi_dokter_hidden" value="{{ old('idreservasi_dokter') ?? $selectedTemu ?? '' }}">
                <input type="hidden" name="dokter_pemeriksa" id="dokter_pemeriksa_hidden" value="{{ $preselectedDoctorId ?? '' }}">

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
                    <a href="{{ route('perawat.antrian.index') }}" class="btn btn-secondary btn-lg">
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
        const idreservasiHidden = document.getElementById('idreservasi_dokter_hidden');
        const dokterPemeriksaHidden = document.getElementById('dokter_pemeriksa_hidden');

        // If there's no select (we're creating from a single appointment), nothing to wire up.
        if (!pasienSelect) {
            // still ensure hidden fields exist (they are rendered server-side in that case)
            // nothing more to do in JS
        } else {

        pasienSelect.addEventListener('change', function() {
            const selected = pasienSelect.options[pasienSelect.selectedIndex];
            idreservasiHidden.value = selected.getAttribute('data-appointment') || '';
            dokterPemeriksaHidden.value = selected.getAttribute('data-dokterid') || '';
        });

            // Trigger change on load if an option is preselected (from URL params)
            if (pasienSelect.value) {
                pasienSelect.dispatchEvent(new Event('change'));
            }

        // Fallback: if there's a temu_dokter_id in URL but no option selected,
        // try to find option with matching data-appointment and select it client-side.
            (function() {
            const params = new URLSearchParams(window.location.search);
            const temuId = params.get('temu_dokter_id') || params.get('idreservasi_dokter') || params.get('temu') || params.get('temu_dokter');
            if (!temuId) return;

            // if already has a selected option, nothing to do
            const hasSelected = Array.from(pasienSelect.options).some(o => o.selected);
                if (hasSelected) {
                // if select already has selection, ensure hidden fields set when disabled
                if (temuId && pasienSelect.disabled) {
                    const opt = Array.from(pasienSelect.options).find(o => o.getAttribute('data-appointment') === temuId);
                    if (opt) {
                        // set hidden inputs
                        idreservasiHidden.value = opt.getAttribute('data-appointment') || '';
                        dokterPemeriksaHidden.value = opt.getAttribute('data-dokterid') || '';
                        ensureHiddenIdpet(opt.value);
                    }
                }
                return;
            }

            const option = Array.from(pasienSelect.options).find(o => o.getAttribute('data-appointment') === temuId);
            if (option) {
                option.selected = true;
                pasienSelect.dispatchEvent(new Event('change'));
                // disable select to prevent change
                pasienSelect.setAttribute('disabled', '');
                // set hidden inputs and ensure idpet hidden exists
                idreservasiHidden.value = option.getAttribute('data-appointment') || '';
                dokterPemeriksaHidden.value = option.getAttribute('data-dokterid') || '';
                ensureHiddenIdpet(option.value);
            }

            function ensureHiddenIdpet(value) {
                if (!document.querySelector('input[name="idpet"][type="hidden"]')) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'idpet';
                    input.value = value;
                    pasienSelect.parentNode.appendChild(input);
                }
            }
            })();
        }

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
