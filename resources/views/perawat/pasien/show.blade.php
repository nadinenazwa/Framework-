@extends('layouts.lte.main')

@section('title', 'Rekam Medis - ' . ($pasien->nama ?? 'Pasien'))

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.pasien.index') }}">Daftar Pasien</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pasien->nama }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-file-medical"></i> Riwayat Rekam Medis
            </h2>
            <p class="text-muted">Semua rekam medis untuk {{ $pasien->nama }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('perawat.pasien.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Patient Information Card -->
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
                        <dd class="col-sm-8"><strong>{{ $pasien->nama }}</strong></dd>
                        <dt class="col-sm-4">Jenis Hewan:</dt>
                        <dd class="col-sm-8">{{ $pasien->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</dd>
                        <dt class="col-sm-4">Ras:</dt>
                        <dd class="col-sm-8">{{ $pasien->rasHewan->nama_ras ?? '-' }}</dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">Pemilik:</dt>
                        <dd class="col-sm-8"><strong>{{ $pasien->pemilik->user->nama ?? '-' }}</strong></dd>
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $pasien->pemilik->user->email ?? '-' }}</dd>
                        <dt class="col-sm-4">No. HP:</dt>
                        <dd class="col-sm-8">{{ $pasien->pemilik->no_hp ?? '-' }}</dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-4">Alamat:</dt>
                        <dd class="col-sm-8"><small>{{ $pasien->pemilik->alamat ?? '-' }}</small></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Records History -->
    @if($riwayat->count() > 0)
        @foreach($riwayat as $rekam)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-event"></i> 
                            Kunjungan: {{ $rekam->created_at ? $rekam->created_at->format('d M Y') : $rekam->temuDokter->waktu_daftar->format('d M Y') }}
                        </h5>
                        <small>Dokter: {{ $rekam->dokterPemeriksa->user->nama ?? '-' }}</small>
                    </div>
                    <a href="{{ route('perawat.rekam-medis.edit', $rekam->idrekam_medis) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
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
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('dokter.detail_rekam_medis.show', $detail->iddetail_rekam_medis) }}" 
                                                   class="btn btn-info" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('dokter.detail_rekam_medis.edit', $detail->iddetail_rekam_medis) }}" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteDetailModal{{ $detail->iddetail_rekam_medis }}"
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteDetailModal{{ $detail->iddetail_rekam_medis }}" 
                                                 tabindex="-1" aria-labelledby="deleteDetailModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteDetailModalLabel">
                                                                <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" 
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Yakin ingin menghapus tindakan ini?</p>
                                                            <p class="text-muted small">
                                                                {{ $detail->tindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" 
                                                                    data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('dokter.detail_rekam_medis.destroy', $detail->iddetail_rekam_medis) }}" 
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
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-info-circle"></i> Belum ada detail tindakan/terapi untuk rekam medis ini.
                            <a href="{{ route('dokter.detail_rekam_medis.create', $rekam->idrekam_medis) }}" class="alert-link ms-2">
                                Tambah detail
                            </a>
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
            <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-primary">
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