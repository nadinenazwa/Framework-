@extends('layouts.lte.main')

@section('title', 'Temu Dokter - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Temu Dokter</h3>
                    <a href="{{ route('admin.temu-dokter.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Urut</th>
                                <th>Pet</th>
                                <th>Pemilik</th>
                                <th>Dokter</th>
                                <th>Waktu Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $i => $item)
                            <tr>
                                <td>{{ $items->firstItem() + $i }}</td>
                                <td>{{ $item->no_urut }}</td>
                                <td>{{ optional($item->pet)->nama }}</td>
                                <td>{{ optional(optional($item->pet)->pemilik)->user?->nama }}</td>
                                <td>{{ optional($item->roleUser->user)->nama }}</td>
                                <td>{{ optional($item->waktu_daftar)->format('Y-m-d H:i') }}</td>
                                <td>{{ $item->status == '1' ? 'Menunggu' : ($item->status == '2' ? 'Selesai' : $item->status) }}</td>
                                <td>
                                    <a href="{{ route('admin.temu-dokter.edit', $item->idreservasi_dokter) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.temu-dokter.destroy', $item->idreservasi_dokter) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus reservasi?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8">Tidak ada data.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
