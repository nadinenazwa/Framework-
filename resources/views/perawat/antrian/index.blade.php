@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Daftar Semua Kunjungan</h1>
            <a href="{{ route('perawat.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Semua Kunjungan (Terbaru di Atas)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Waktu Daftar</th>
                                    <th>No. Urut</th>
                                    <th>Nama Pet</th>
                                    <th>Pemilik</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($semuaKunjungan as $temu)
                                <tr>
                                    <td>{{ $temu->waktu_daftar->format('d M Y H:i') }}</td>
                                    <td>{{ $temu->no_urut }}</td>
                                    <td>{{ $temu->pet->nama ?? 'N/A' }}</td>
                                    <td>{{ $temu->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                    <td>{{ $temu->roleUser->user->nama ?? 'N/A' }}</td>
                                    <td>
                                        @if($temu->status == '1')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($temu->status == '2')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Batal</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada riwayat kunjungan.</td>
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