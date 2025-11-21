@extends('layouts.lte.main')

@section('title', 'Tambah Detail Rekam Medis')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dokter.detail-rekam-medis.index') }}">Detail Rekam Medis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-plus-circle"></i> Tambah Detail Rekam Medis
            </h2>
            <p class="text-muted">Tambahkan tindakan/terapi untuk rekam medis pasien</p>
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
                <i class="bi bi-clipboard-check"></i> Form Detail Rekam Medis
            </h5>
        </div>
        <div class="card-body">
            <!-- Medical Record Information -->
            <div class="mb-4 p-3 border rounded bg-light">
                <h6 class="mb-3">
                    <i class="bi bi-info-circle"></i> Informasi Rekam Medis
                </h6>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Pasien (Hewan)</label>
                        <div class="form-control bg-white" readonly>
                            <strong>{{ $rekamMedis->pet->nama_hewan ?? '-' }}</strong><br>
                            <small class="text-muted">{{ $rekamMedis->pet->rasHewan->nama_ras ?? '-' }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pemilik</label>
                        <div class="form-control bg-white" readonly>
                            <strong>{{ $rekamMedis->pet->pemilik->nama_pemilik ?? '-' }}</strong><br>
                            <small class="text-muted">{{ $rekamMedis->pet->pemilik->user->email ?? '-' }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Diagnosis</label>
                        <div class="form-control bg-white text-truncate" readonly title="{{ $rekamMedis->diagnosa }}">
                            <small>{{ Str::limit($rekamMedis->diagnosa, 50) }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Form -->
            <form action="{{ route('dokter.detail_rekam_medis.store', $rekamMedis->idrekam_medis) }}" method="POST" id="detailForm">
                @csrf

                <!-- Treatment Code Selection -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-stethoscope"></i> Pilih Tindakan/Terapi
                    </h6>
                    <div class="mb-3">
                        <label for="idkode_tindakan_terapi" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Kode Tindakan/Terapi
                        </label>
                        <select name="idkode_tindakan_terapi" id="idkode_tindakan_terapi" 
                                class="form-select @error('idkode_tindakan_terapi') is-invalid @enderror" required>
                            <option value="">-- Pilih Tindakan/Terapi --</option>
                            @foreach($treatments as $treatment)
                                <option value="{{ $treatment->idkode_tindakan_terapi }}" @selected(old('idkode_tindakan_terapi') == $treatment->idkode_tindakan_terapi)>
                                    {{ $treatment->nama_kode_tindakan }} - {{ $treatment->kategori->nama_kategori_klinis ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('idkode_tindakan_terapi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Pilih tindakan atau terapi yang diberikan kepada pasien
                        </small>
                    </div>
                </div>

                <!-- Detail Description -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-file-text"></i> Keterangan Detail
                    </h6>
                    <div class="mb-3">
                        <label for="detail" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Detail Tindakan/Terapi
                        </label>
                        <textarea name="detail" id="detail" class="form-control @error('detail') is-invalid @enderror" 
                                  rows="4" required placeholder="Jelaskan detail tindakan/terapi yang diberikan...">{{ old('detail') }}</textarea>
                        @error('detail')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-block mt-2">
                            Berikan penjelasan lengkap tentang tindakan/terapi yang dilakukan
                        </small>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('perawat.rekam-medis.show', $rekamMedis->idrekam_medis) }}" class="btn btn-secondary btn-lg">
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
        const form = document.getElementById('detailForm');

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
