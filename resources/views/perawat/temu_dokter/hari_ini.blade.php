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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($temuDokter as $item)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->waktu_daftar }}</td>
                                <td>{{ $item->pet->nama ?? '-' }}</td>
                                <td>{{ $item->pet->pemilik->user->name ?? '-' }}</td>
                                <td>{{ $item->roleUser->user->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('perawat.pasien.show', $item->pet->idpet) }}" class="btn btn-info btn-sm">Lihat Pasien</a>
                                    <a href="{{ route('perawat.rekam-medis.create', ['pet_id' => $item->pet->idpet, 'temu_dokter_id' => $item->id]) }}" class="btn btn-success btn-sm">Tambah Rekam Medis</a>
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
