@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pet</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pet</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.pet.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Pet
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Sukses!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Gagal!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Warna/Tanda</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Pemilik</th>
                                        <th>Ras Hewan</th>
                                        <th style="width: 200px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pets as $index => $pet)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $pet->nama }}</td>
                                        <td>{{ $pet->tanggal_lahir ? $pet->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $pet->warna_tanda }}</td>
                                        <td>
                                            @if($pet->jenis_kelamin == 'jantan')
                                                <span class="badge bg-primary">Jantan</span>
                                            @else
                                                <span class="badge bg-danger">Betina</span>
                                            @endif
                                        </td>
                                        <td>{{ $pet->pemilik->user->nama ?? '-' }}</td>
                                        <td>{{ $pet->rasHewan->nama_ras ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.pet.edit', $pet->idpet) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.pet.destroy', $pet->idpet) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Tidak ada data pet</td>
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

