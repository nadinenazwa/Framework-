@extends('layouts.lte.main')


@section('title', 'Dashboard Resepsionis')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Dashboard Resepsionis</h2>
            <p class="text-muted">Selamat datang, {{ Auth::user()->name ?? session('user_name') }}!</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill display-4 text-primary"></i>
                    <h5 class="card-title mt-2">Total Pemilik</h5>
                    <h2 class="fw-bold">{{ $totalPemilik ?? '-' }}</h2>
                    <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-outline-primary btn-sm mt-2">Lihat Pemilik</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-paw display-4 text-success"></i>
                    <h5 class="card-title mt-2">Total Hewan</h5>
                    <h2 class="fw-bold">{{ $totalPet ?? '-' }}</h2>
                    <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-outline-success btn-sm mt-2">Lihat Hewan</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-check display-4 text-info"></i>
                    <h5 class="card-title mt-2">Total Temu Dokter</h5>
                    <h2 class="fw-bold">{{ $totalTemuDokter ?? '-' }}</h2>
                    <a href="{{ route('resepsionis.temu-dokter.index') }}" class="btn btn-outline-info btn-sm mt-2">Lihat Temu Dokter</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
