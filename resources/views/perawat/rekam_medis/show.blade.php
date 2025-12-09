@extends('layouts.lte.main')

@section('title', 'Rekam Medis - ' . ($rekamMedis->pet->nama ?? 'Pasien'))

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.pasien.index') }}">Daftar Pasien</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $rekamMedis->pet->nama ?? '-' }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-file-medical"></i> Riwayat Rekam Medis
            </h2>
            <p class="text-muted">Detail rekam medis untuk {{ $rekamMedis->pet->nama ?? '-' }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Patient Information Card -->
    @php
        // Prefer direct relation if present, otherwise fall back to temuDokter->pet
        $pet = $rekamMedis->pet ?? ($rekamMedis->temuDokter->pet ?? null);
    @endphp

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-paw"></i> Informasi Pasien
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">Nama Pasien:</dt>
                        <dd class="col-sm-8"><strong>{{ $pet->nama ?? '-' }}</strong></dd>
                        <dt class="col-sm-4">Jenis Hewan:</dt>
                        <dd class="col-sm-8">{{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</dd>
                        <dt class="col-sm-4">Ras:</dt>
                        <dd class="col-sm-8">{{ $pet->rasHewan->nama_ras ?? '-' }}</dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">Pemilik:</dt>
                        <dd class="col-sm-8"><strong>{{ $pet->pemilik->user->nama ?? '-' }}</strong></dd>
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $pet->pemilik->user->email ?? '-' }}</dd>
                        <dt class="col-sm-4">No. HP:</dt>
                        <dd class="col-sm-8">{{ $pet->pemilik->no_wa ?? '-' }}</dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">Alamat:</dt>
                        <dd class="col-sm-8"><small>{{ $pet->pemilik->alamat ?? '-' }}</small></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Records History -->
    @php
        // If the controller passed a collection of records (as $riwayat) use it,
        // otherwise render the single $rekamMedis as a one-item collection so
        // the existing markup below can be reused.
        $riwayat = isset($riwayat) ? $riwayat : collect([$rekamMedis]);
    @endphp

    @if($riwayat->count() > 0)
        @foreach($riwayat as $rekam)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <div>
                                <h5 class="mb-0">
                                    <i class="bi bi-calendar-event"></i>
                                    Kunjungan: {{ optional(optional($rekam->temuDokter)->waktu_daftar)->format('d M Y') ?: '-' }}
                                </h5>
                        <small>Dokter: {{ $rekam->dokterPemeriksa->user->nama ?? '-' }}</small>
                    </div>
                    <div class="btn-group" role="group" aria-label="Rekam actions">
                        <a href="{{ route('perawat.rekam-medis.edit', $rekam->idrekam_medis) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        <form action="{{ route('perawat.rekam-medis.destroy', $rekam->idrekam_medis) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Yakin ingin menghapus (soft delete) rekam medis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6 class="border-bottom pb-2">
                                <i class="bi bi-chat-left-quote"></i> Anamnesa
                            </h6>
                            <p class="text-muted small">{{ $rekam->anamnesa }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="border-bottom pb-2">
                                <i class="bi bi-search"></i> Temuan Klinis
                            </h6>
                            <p class="text-muted small">{{ $rekam->temuan_klinis }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="border-bottom pb-2">
                                <i class="bi bi-clipboard2-check"></i> Diagnosis
                            </h6>
                            <p class="text-muted small">{{ $rekam->diagnosa }}</p>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-list-check"></i> Detail Tindakan / Terapi
                    </h6>

                    @if($rekam->detailRekamMedis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="col-1">No.</th>
                                        <th class="col-3">Tindakan</th>
                                        <th class="col-4">Keterangan</th>
                                        <th class="col-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekam->detailRekamMedis as $detail)
                                    <tr>
                                        <td class="fw-bold">{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $detail->tindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}</strong><br>
                                            <small class="text-muted">Kategori: {{ $detail->tindakanTerapi->kategori->nama_kategori_klinis ?? '-' }}</small>
                                        </td>
                                        <td><small>{{ $detail->detail }}</small></td>
                                        <td>-</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-info-circle"></i> Belum ada detail tindakan/terapi untuk rekam medis ini.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info text-center py-5" role="alert">
            <i class="bi bi-info-circle" style="font-size: 2.5rem;"></i>
            <h5 class="mt-3">Belum Ada Rekam Medis</h5>
            <p class="mb-3">Belum ada riwayat rekam medis untuk pasien ini.</p>
            <a href="{{ route('perawat.antrian.index') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Buat Rekam Medis Baru
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
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