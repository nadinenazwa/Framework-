@extends('layouts.lte.main')

@section('title', 'Detail Reservasi')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.temu-dokter.index') }}">Temu Dokter</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Reservasi</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Detail Reservasi #{{ $temuDokter->idreservasi_dokter }}</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <dl class="row">
                <dt class="col-sm-3">No. Urut</dt>
                <dd class="col-sm-9">{{ $temuDokter->no_urut }}</dd>

                <dt class="col-sm-3">Waktu Daftar</dt>
                <dd class="col-sm-9">{{ optional($temuDokter->waktu_daftar)->format('d M Y H:i') }}</dd>

                <dt class="col-sm-3">Pet</dt>
                <dd class="col-sm-9">{{ $temuDokter->pet->nama ?? '-' }}</dd>

                <dt class="col-sm-3">Pemilik</dt>
                <dd class="col-sm-9">{{ $temuDokter->pet->pemilik->nama_pemilik ?? '-' }}</dd>

                <dt class="col-sm-3">Dokter</dt>
                <dd class="col-sm-9">{{ $temuDokter->roleUser->user->nama ?? '-' }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ $temuDokter->status }}</dd>
            </dl>

            <div class="d-flex justify-content-end">
                <a href="{{ route('resepsionis.temu-dokter.edit', $temuDokter->idreservasi_dokter) }}" class="btn btn-warning me-2">Edit</a>
                <form action="{{ route('resepsionis.temu-dokter.destroy', $temuDokter->idreservasi_dokter) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
