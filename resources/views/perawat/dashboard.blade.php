@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perawat Dashboard</h1>
    <p>Selamat datang, {{ Auth::user()->nama }}!</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Antrian & Riwayat Kunjungan</h5>
                    <p class="card-text">Lihat semua daftar antrian dan riwayat temu dokter.</p>
                    <a href="{{ route('perawat.antrian.index') }}" class="btn btn-primary">Lihat Daftar Kunjungan</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Pasien</h5>
                    <p class="card-text">Cari dan lihat riwayat rekam medis pasien.</p>
                    <a href="{{ route('perawat.pasien.index') }}" class="btn btn-info">Lihat Daftar Pasien</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection