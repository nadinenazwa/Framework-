@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Dokter</h1>
    
    <p>Selamat datang, {{ Auth::user()->nama }}!</p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Pasien Anda</h5>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Pasien</th>
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
                                    <td colspan="5" class="text-center">Belum ada pasien yang ditangani.</td>
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
@endsection