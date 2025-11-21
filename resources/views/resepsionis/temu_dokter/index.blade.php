@extends('layouts.lte.main')

@section('title', 'Daftar Temu Dokter')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Temu Dokter</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-md-8">
            <h2>
                <i class="bi bi-calendar-check"></i> Daftar Temu Dokter
            </h2>
            <p class="text-muted">Kelola reservasi temu dokter</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('resepsionis.temu-dokter.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Reservasi
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-list"></i> Daftar Tunggu</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Waktu Daftar</th>
                            <th>Nama Pet</th>
                            <th>Pemilik</th>
                            <th>Dokter</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarTunggu as $temu)
                        <tr>
                            <td class="fw-bold">{{ $temu->no_urut }}</td>
                            <td>{{ optional($temu->waktu_daftar)->format('d M Y H:i') }}</td>
                            <td>{{ $temu->pet->nama ?? '-' }}</td>
                            <td>{{ $temu->pet->pemilik->nama_pemilik ?? '-' }}</td>
                            <td>{{ $temu->roleUser->user->nama ?? '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('resepsionis.temu-dokter.show', $temu->idreservasi_dokter) }}" class="btn btn-info" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('resepsionis.temu-dokter.edit', $temu->idreservasi_dokter) }}" class="btn btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $temu->idreservasi_dokter }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $temu->idreservasi_dokter }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin ingin menghapus reservasi ini?</p>
                                                <p><strong>Pet:</strong> {{ $temu->pet->nama ?? '-' }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('resepsionis.temu-dokter.destroy', $temu->idreservasi_dokter) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada reservasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection