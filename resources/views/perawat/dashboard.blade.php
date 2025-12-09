@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Perawat</h3>
                <p class="text-muted">Selamat datang, {{ Auth::user()->name ?? Auth::user()->nama }}!</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Antrian</h6>
                                <h2 class="mb-0">{{ $totalAntrian ?? '-' }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-list-ul"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-info bg-opacity-25">
                        <small><a href="{{ route('perawat.antrian.index') }}" class="text-white text-decoration-none">Lihat <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Kunjungan Selesai</h6>
                                <h2 class="mb-0">{{ $totalSelesai ?? '-' }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-25">
                        <small><a href="{{ route('perawat.antrian.index') }}" class="text-white text-decoration-none">Lihat <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Menunggu</h6>
                                <h2 class="mb-0">{{ $totalMenunggu ?? '-' }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-warning bg-opacity-25">
                        <small><a href="{{ route('perawat.antrian.index') }}" class="text-white text-decoration-none">Lihat <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Pasien</h6>
                                <h2 class="mb-0">{{ $totalPasien ?? '-' }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary bg-opacity-25">
                        <small><a href="{{ route('perawat.pasien.index') }}" class="text-white text-decoration-none">Lihat <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3 mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tindakan Cepat</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('perawat.antrian.index') }}" class="btn btn-primary btn-lg"><i class="bi bi-list-ul"></i> Lihat Antrian</a>
                            <a href="{{ route('perawat.profil.show') }}" class="btn btn-secondary btn-lg"><i class="bi bi-person-circle"></i> Profil Saya</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Appointments</h3>
                    </div>
                    <div class="card-body">
                        @if(isset($recentAppointments) && $recentAppointments->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Nama Pet</th>
                                            <th>Dokter</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentAppointments as $temu)
                                        <tr>
                                            <td>{{ optional($temu->waktu_daftar)->format('d M Y H:i') }}</td>
                                            <td>{{ $temu->pet->nama ?? '-' }}</td>
                                            <td>{{ $temu->roleUser->user->nama ?? '-' }}</td>
                                            <td>
                                                @if($temu->status == '1' || $temu->status == 1)
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif($temu->status == '2' || $temu->status == 2)
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-secondary">Batal</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Belum ada temu dokter terbaru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection