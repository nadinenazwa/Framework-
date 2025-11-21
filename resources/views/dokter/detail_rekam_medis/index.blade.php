@extends('layouts.lte.main')

@section('title', 'Daftar Detail Rekam Medis')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Rekam Medis</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-list-check"></i> Daftar Detail Rekam Medis
            </h2>
            <p class="text-muted">Kelola tindakan dan terapi untuk rekam medis pasien</p>
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

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="bi bi-funnel"></i> Filter Pencarian
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dokter.detail-rekam-medis.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari berdasarkan pasien atau pemilik</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Nama pasien atau pemilik..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('dokter.detail-rekam-medis.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-table"></i> Data Detail Rekam Medis
            </h5>
        </div>
        <div class="card-body">
            @if($detailRekamMedis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="col-1">
                                    <i class="bi bi-hash"></i> ID
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-paw"></i> Pasien
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-person"></i> Pemilik
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-stethoscope"></i> Tindakan
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-file-text"></i> Keterangan
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-gear"></i> Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailRekamMedis as $detail)
                                <tr>
                                    <td class="fw-bold">{{ $detail->iddetail_rekam_medis }}</td>
                                    <td>
                                        <strong>{{ $detail->rekamMedis->pet->nama_hewan ?? '-' }}</strong><br>
                                        <small class="text-muted">
                                            Ras: {{ $detail->rekamMedis->pet->rasHewan->nama_ras ?? '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        {{ $detail->rekamMedis->pet->pemilik->nama_pemilik ?? '-' }}<br>
                                        <small class="text-muted">
                                            {{ $detail->rekamMedis->pet->pemilik->user->email ?? '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ $detail->tindakanTerapi->nama_kode_tindakan ?? '-' }}</strong><br>
                                        <small class="text-muted">
                                            {{ $detail->tindakanTerapi->kategori->nama_kategori_klinis ?? '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($detail->detail, 50) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('dokter.detail_rekam_medis.show', $detail->iddetail_rekam_medis) }}" 
                                               class="btn btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('dokter.detail_rekam_medis.edit', $detail->iddetail_rekam_medis) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $detail->iddetail_rekam_medis }}"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $detail->iddetail_rekam_medis }}" 
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
                                                        <p>Apakah Anda yakin ingin menghapus detail rekam medis ini?</p>
                                                        <div class="bg-light p-3 rounded">
                                                            <strong>Pasien:</strong> {{ $detail->rekamMedis->pet->nama_hewan ?? '-' }}<br>
                                                            <strong>Tindakan:</strong> {{ $detail->tindakanTerapi->nama_kode_tindakan ?? '-' }}
                                                        </div>
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $detailRekamMedis->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-info-circle" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3">Belum Ada Data Detail Rekam Medis</h5>
                    <p class="mb-3">Tidak ada detail tindakan/terapi yang tersimpan dalam sistem.</p>
                    <a href="{{ route('dokter.dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
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
