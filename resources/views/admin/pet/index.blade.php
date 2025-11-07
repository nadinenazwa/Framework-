@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pet</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pet.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Pet
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Warna/Tanda</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pemilik</th>
                                    <th>Ras Hewan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pets as $index => $pet)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pet->nama }}</td>
                                        <td>{{ $pet->tanggal_lahir ? $pet->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $pet->warna_tanda }}</td>
                                        <td>
                                            @if($pet->jenis_kelamin == 'jantan')
                                                <span style="color: #000000;">Jantan</span>
                                            @else
                                                <span style="color: #000000;">Betina</span>
                                            @endif
                                        </td>
                                        <td>{{ $pet->pemilik->user->nama ?? '-' }}</td>
                                        <td>{{ $pet->rasHewan->nama_ras ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.pet.edit', $pet->idpet) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.pet.destroy', $pet->idpet) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data pet</td>
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
