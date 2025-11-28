@extends('layouts.lte.main')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Dashboard Perawat</h2>
            <p class="text-muted">Selamat datang, {{ Auth::user()->name ?? Auth::user()->nama }}!</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Antrian & Riwayat Kunjungan</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Lihat semua daftar antrian dan riwayat temu dokter.</p>
                    <a href="{{ route('perawat.antrian.index') }}" class="btn btn-primary">
                        <i class="bi bi-list-ul"></i> Lihat Daftar Kunjungan
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-people-fill"></i> Riwayat Pasien</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Cari dan lihat riwayat rekam medis pasien.</p>
                    <a href="{{ route('perawat.pasien.index') }}" class="btn btn-info">
                        <i class="bi bi-search"></i> Lihat Daftar Pasien
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection