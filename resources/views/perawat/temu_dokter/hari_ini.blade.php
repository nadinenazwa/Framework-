@extends('layouts.lte.main')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header"><h3 class="card-title">Temu Dokter Hari Ini</h3></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Waktu Daftar</th>
                                <th>Nama Pasien</th>
                                <th>Pemilik</th>
                                <th>Dokter</th>
                                <th style="width:120px">Rekam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($temuDokter as $item)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->waktu_daftar }}</td>
                                <td>{{ $item->pet->nama ?? '-' }}</td>
                                <td>{{ $item->pet->pemilik->user->nama ?? '-' }}</td>
                                <td>{{ $item->roleUser->user->nama ?? '-' }}</td>
                                <td>
                                    @if($item->rekamMedis)
                                        <span class="badge bg-success">Ada</span>
                                    @else
                                        <span class="badge bg-secondary">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="{{ route('perawat.pasien.show', $item->pet->idpet) }}" class="btn btn-info btn-sm">Lihat Pasien</a>
                                        @if($item->rekamMedis)
                                            <a href="{{ route('perawat.rekam-medis.show', $item->rekamMedis->idrekam_medis) }}" class="btn btn-primary btn-sm">Lihat Rekam</a>
                                            <a href="{{ route('perawat.rekam-medis.edit', $item->rekamMedis->idrekam_medis) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('perawat.rekam-medis.destroy', $item->rekamMedis->idrekam_medis) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus rekam medis ini?')">Hapus</button>
                                            </form>
                                        @else
                                            <a href="{{ route('perawat.rekam-medis.create', ['pet_id' => $item->pet->idpet, 'temu_dokter_id' => $item->idreservasi_dokter]) }}" class="btn btn-success btn-sm">Tambah Rekam</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
