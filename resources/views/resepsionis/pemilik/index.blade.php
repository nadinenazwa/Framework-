@extends('layouts.lte.main')

@section('title', 'Daftar Pemilik')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pemilik</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-person"></i> Daftar Pemilik Hewan
            </h2>
            <p class="text-muted">Kelola data pemilik hewan peliharaan</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('resepsionis.pemilik.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Tambah Pemilik
            </a>
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

    <!-- Main Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-table"></i> Data Pemilik
            </h5>
        </div>
        <div class="card-body">
            @if($pemilik->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="col-1">
                                    <i class="bi bi-hash"></i> ID
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-person"></i> Nama
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-telephone"></i> No. HP
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-envelope"></i> Email
                                </th>
                                <th class="col-1">
                                    <i class="bi bi-paw"></i> Hewan
                                </th>
                                <th class="col-2">
                                    <i class="bi bi-gear"></i> Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemilik as $p)
                                <tr>
                                    <td class="fw-bold">{{ $p->idpemilik }}</td>
                                    <td>
                                        <strong>{{ $p->nama_pemilik ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $p->no_hp ?? '#' }}">
                                            {{ $p->no_hp ?? '-' }}
                                        </a>
                                    </td>
                                    <td>
                                        <small>
                                            <a href="mailto:{{ $p->user->email ?? '#' }}">
                                                {{ $p->user->email ?? '-' }}
                                            </a>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $p->pet->count() ?? 0 }} hewan
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('resepsionis.pemilik.show', $p->idpemilik) }}" 
                                               class="btn btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('resepsionis.pemilik.edit', $p->idpemilik) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $p->idpemilik }}"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $p->idpemilik }}" 
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
                                                        <p>Apakah Anda yakin ingin menghapus pemilik ini beserta akunnya?</p>
                                                        <div class="bg-light p-3 rounded">
                                                            <strong>Nama:</strong> {{ $p->nama_pemilik ?? '-' }}<br>
                                                            <strong>Email:</strong> {{ $p->user->email ?? '-' }}<br>
                                                            <strong>Hewan:</strong> {{ $p->pet->count() ?? 0 }} hewan terdaftar
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" 
                                                                data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('resepsionis.pemilik.destroy', $p->idpemilik) }}" 
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
                    {{ $pemilik->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="bi bi-info-circle" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-3">Belum Ada Data Pemilik</h5>
                    <p class="mb-3">Tidak ada pemilik hewan yang terdaftar dalam sistem.</p>
                    <a href="{{ route('resepsionis.pemilik.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Daftarkan Pemilik Pertama
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
