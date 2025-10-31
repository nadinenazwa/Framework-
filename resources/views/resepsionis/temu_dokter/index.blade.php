@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Daftar Tunggu (Temu Dokter)</h1>
            <a href="{{ route('resepsionis.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pasien Menunggu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No. Urut</th>
                                    <th>Waktu Daftar</th>
                                    <th>Nama Pet</th>
                                    <th>Pemilik</th>
                                    <th>Dokter</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftarTunggu as $temu)
                                <tr>
                                    <td><strong>{{ $temu->no_urut }}</strong></td>
                                    <td>{{ $temu->waktu_daftar->format('d M Y H:i') }}</td>
                                    <td>{{ $temu->pet->nama ?? 'N/A' }}</td>
                                    <td>{{ $temu->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                    <td>{{ $temu->roleUser->user->nama ?? 'N/A' }}</td>                                
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada pasien dalam daftar tunggu.</td>
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