@extends('layouts.lte.main')

@section('content')
<div class="container">
    <h1>Daftar Rekam Medis</h1>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Status</th>
                        <th>Diagnosa</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis as $rekam)
                    <tr>
                        <td>{{ $rekam->temuDokter->pet->nama ?? 'N/A' }}</td>
                        <td>{{ $rekam->dokterPemeriksa->user->name ?? 'N/A' }}</td>
                        <td>
                            @php $status = optional($rekam->temuDokter)->status; @endphp
                            @if($status == '1' || strtolower($status) === 'pending' || strtolower($status) === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($status == '2' || strtolower($status) === '2' || strtolower($status) === 'selesai' || strtolower($status) === 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Batal</span>
                            @endif
                        </td>
                        <td>{{ $rekam->diagnosa ?? 'N/A' }}</td>
                        <td>
                            {{ optional($rekam->temuDokter)->waktu_daftar ? $rekam->temuDokter->waktu_daftar->format('d-m-Y H:i') : 'N/A' }}
                        </td>
                        <td>
                            <a href="{{ route('dokter.rekam_medis.show', $rekam->idrekam_medis) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('dokter.detail_rekam_medis.create', ['rekamMedis' => $rekam->idrekam_medis]) }}" class="btn btn-primary btn-sm">Tambah Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection