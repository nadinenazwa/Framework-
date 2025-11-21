@extends('layouts.lte.main')

@section('title', 'Rekam Medis - Admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Daftar Rekam Medis</h3>
            <a href="{{ route('admin.rekam-medis.create') }}" class="btn btn-primary btn-sm">Tambah</a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pet</th>
                        <th>Pemilik</th>
                        <th>Dokter</th>
                        <th>Diagnosa</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekamMedis as $i => $rm)
                        <tr>
                            <td>{{ $rekamMedis->firstItem() + $i }}</td>
                            <td>{{ optional($rm->pet)->nama ?? optional(optional($rm->temuDokter)->pet)->nama ?? '—' }}</td>
                            <td>{{ optional(optional($rm->pet)->pemilik)->user?->nama ?? optional(optional(optional($rm->temuDokter)->pet)->pemilik)->user?->nama ?? '—' }}</td>
                            <td>{{ optional($rm->dokterPemeriksa->user)->nama ?? '—' }}</td>
                            <td>{{ Str::limit($rm->diagnosa, 80) }}</td>
                            <td>{{ optional($rm->created_at)->format('Y-m-d') ?: optional(optional($rm->temuDokter)->waktu_daftar)->format('Y-m-d') ?: '—' }}</td>
                            <td>
                                <a href="{{ route('admin.rekam-medis.edit', $rm->idrekam_medis) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.rekam-medis.destroy', $rm->idrekam_medis) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus rekam medis?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $rekamMedis->links() }}
        </div>
    </div>
</div>
@endsection
