@extends('layouts.lte.main')

@section('title', 'Detail Rekam Medis - ' . ($rekamMedis->pet->nama_hewan ?? 'Pasien'))

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.index') }}">Rekam Medis</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $rekamMedis->pet->nama_hewan ?? '-' }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-file-medical"></i> Detail Rekam Medis
            </h2>
            <p class="text-muted">Informasi lengkap rekam medis pasien</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group" role="group">
                <a href="{{ route('perawat.rekam-medis.edit', $rekamMedis->idrekam_medis) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">
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

    <!-- Patient Information Card -->
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
                            <strong>{{ $rekamMedis->pet->nama_hewan ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">Jenis:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->pet->jenisHewan->nama_jenis_hewan ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Ras:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->pet->rasHewan->nama_ras ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Warna:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->pet->warna ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Berat:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->pet->berat_badan ?? '-' }} kg
                        </dd>

                        <dt class="col-sm-5">Umur:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->pet->umur ?? '-' }} tahun
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
                            <strong>{{ $rekamMedis->pet->pemilik->nama_pemilik ?? '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">No. HP:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->pet->pemilik->no_hp ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Email:</dt>
                        <dd class="col-sm-7">
                            <small>{{ $rekamMedis->pet->pemilik->user->email ?? '-' }}</small>
                        </dd>

                        <dt class="col-sm-5">Alamat:</dt>
                        <dd class="col-sm-7">
                            <small>{{ $rekamMedis->pet->pemilik->alamat ?? '-' }}</small>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-event"></i> Jadwal Pemeriksaan
                    </h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Tanggal:</dt>
                        <dd class="col-sm-7">
                            <strong>{{ $rekamMedis->temuDokter->waktu_daftar ? date('d/m/Y', strtotime($rekamMedis->temuDokter->waktu_daftar)) : '-' }}</strong>
                        </dd>

                        <dt class="col-sm-5">Jam:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->temuDokter->waktu_daftar ? date('H:i', strtotime($rekamMedis->temuDokter->waktu_daftar)) : '-' }}
                        </dd>

                        <dt class="col-sm-5">Dokter:</dt>
                        <dd class="col-sm-7">
                            {{ $rekamMedis->dokterPemeriksa->user->name ?? '-' }}
                        </dd>

                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
                            @if($rekamMedis->temuDokter->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($rekamMedis->temuDokter->status == 'proses')
                                <span class="badge bg-warning">Proses</span>
                            @else
                                <span class="badge bg-secondary">{{ $rekamMedis->temuDokter->status ?? '-' }}</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Clinical Information Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-stethoscope"></i> Informasi Klinis
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-chat-left-quote"></i> Anamnesis
                    </h6>
                    <p class="card bg-light p-3 rounded">
                        {{ $rekamMedis->anamnesa ?? '-' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-search"></i> Temuan Klinis
                    </h6>
                    <p class="card bg-light p-3 rounded">
                        {{ $rekamMedis->temuan_klinis ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-clipboard2-check"></i> Diagnosis
                    </h6>
                    <p class="card bg-light p-3 rounded">
                        {{ $rekamMedis->diagnosa ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Record Details Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-list-check"></i> Detail Tindakan & Terapi
            </h5>
            <a href="{{ route('perawat.detail_rekam_medis.create', ['rekamMedis' => $rekamMedis->idrekam_medis]) }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Detail
            </a>
        </div>
        <div class="card-body">
            @if($rekamMedis->detailRekamMedis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="col-1">No.</th>
                                <th class="col-4">Tindakan/Terapi</th>
                                <th class="col-5">Keterangan</th>
                                <th class="col-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekamMedis->detailRekamMedis as $detail)
                                <tr>
                                    <td class="fw-bold">{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $detail->tindakanTerapi->nama_kode_tindakan ?? '-' }}</strong><br>
                                        <small class="text-muted">Kategori: {{ $detail->tindakanTerapi->kategori->nama_kategori_klinis ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($detail->detail, 100) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('perawat.detail_rekam_medis.show', $detail->iddetail_rekam_medis) }}" 
                                               class="btn btn-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('perawat.detail_rekam_medis.edit', $detail->iddetail_rekam_medis) }}" 
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
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteDetailModalLabel">
                                                            <i class="bi bi-exclamation-triangle"></i> Konfirmasi Penghapusan
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" 
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus detail ini?</p>
                                                        <div class="bg-light p-3 rounded">
                                                            <strong>Tindakan:</strong> {{ $detail->tindakanTerapi->nama_kode_tindakan ?? '-' }}<br>
                                                            <strong>Keterangan:</strong> {{ Str::limit($detail->detail, 50) }}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" 
                                                                data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('perawat.detail_rekam_medis.destroy', $detail->iddetail_rekam_medis) }}" 
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
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> Belum ada detail tindakan/terapi untuk rekam medis ini.
                    <a href="{{ route('perawat.detail_rekam_medis.create', ['rekamMedis' => $rekamMedis->idrekam_medis]) }}" class="alert-link">
                        Tambah sekarang
                    </a>
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
                <dt class="col-sm-3">ID Rekam Medis:</dt>
                <dd class="col-sm-9">
                    <code>{{ $rekamMedis->idrekam_medis }}</code>
                </dd>

                <dt class="col-sm-3">Dibuat pada:</dt>
                <dd class="col-sm-9">
                    {{ $rekamMedis->created_at ? $rekamMedis->created_at->format('d/m/Y H:i:s') : '-' }}
                </dd>

                <dt class="col-sm-3">Terakhir diperbarui:</dt>
                <dd class="col-sm-9">
                    {{ $rekamMedis->updated_at ? $rekamMedis->updated_at->format('d/m/Y H:i:s') : '-' }}
                </dd>
            </dl>
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
