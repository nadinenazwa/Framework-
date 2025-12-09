@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
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
                                <h6 class="card-title mb-2">Total Pasien</h6>
                                <h2 class="mb-0">{{ $totalPatients ?? '-' }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-info bg-opacity-25">
                        <small><a href="{{ route('dokter.pasien.index') }}" class="text-white text-decoration-none">Kelola <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Rekam Medis</h6>
                                <h2 class="mb-0">{{ $totalMedicalRecords ?? '-' }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-file-medical-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-secondary bg-opacity-25">
                        <small><a href="{{ route('dokter.rekam_medis') }}" class="text-white text-decoration-none">Kelola <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Detail Rekam Medis</h6>
                                <h2 class="mb-0">{{ $totalDetailRekam ?? '-' }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-list-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-dark bg-opacity-25">
                        <small><a href="{{ route('dokter.detail-rekam-medis.index') }}" class="text-white text-decoration-none">Kelola <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Pemeriksaan Belum Selesai</h6>
                                <h2 class="mb-0">{{ $pendingCount ?? 0 }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-warning bg-opacity-25">
                        <small><a href="{{ route('dokter.rekam_medis') }}" class="text-white text-decoration-none">Lihat <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <p>Selamat datang, {{ Auth::user()->nama }}!</p>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Daftar Pasien Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nama Pasien</th>
                                        <th>Terakhir Kunjungan</th>
                                        <th>Jenis Hewan</th>
                                        <th>Ras</th>
                                        <th>Pemilik</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pasiens as $pasien)
                                    <tr>
                                        <td>{{ $pasien->nama }}</td>
                                        <td>{{ optional($pasien->last_visit)->format('d M Y H:i') ?? '-' }}</td>
                                        <td>{{ $pasien->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</td>
                                        <td>{{ $pasien->rasHewan->nama_ras ?? 'N/A' }}</td>
                                        <td>{{ $pasien->pemilik->user->nama ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('dokter.rekam_medis.index', $pasien->idpet) }}" class="btn btn-primary btn-sm">
                                                Lihat Rekam Medis
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada pasien terbaru.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pemeriksaan Menunggu (Terbaru)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Waktu Daftar</th>
                                        <th>No. Urut</th>
                                        <th>Pet</th>
                                        <th>Pemilik</th>
                                        <th>Dokter</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendingVisits as $visit)
                                    <tr>
                                        <td>{{ optional($visit->waktu_daftar)->format('d M Y H:i') ?? '-' }}</td>
                                        <td>{{ $visit->no_urut }}</td>
                                        <td>{{ $visit->pet->nama ?? 'N/A' }}</td>
                                        <td>{{ optional($visit->pet->pemilik->user)->nama ?? 'N/A' }}</td>
                                        <td>{{ optional($visit->roleUser->user)->nama ?? 'N/A' }}</td>
                                        <td>
                                            @php $s = strtolower((string) ($visit->status ?? '')) ; @endphp
                                            @if($s === '1' || $s === 'pending' || $s === 'menunggu')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($s === '2' || $s === 'selesai' || $s === 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Batal</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($visit->rekamMedis)
                                                <a href="{{ route('dokter.rekam_medis.show', $visit->rekamMedis->idrekam_medis) }}" class="btn btn-sm btn-primary">Lihat Rekam</a>
                                            @else
                                                <a href="{{ route('dokter.rekam_medis.index', ['petId' => $visit->pet->idpet ?? null]) }}" class="btn btn-sm btn-secondary">Lihat</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada pemeriksaan menunggu.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection