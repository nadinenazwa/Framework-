@extends('layouts.lte.main')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-person-badge"></i> Profil Perawat</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128" class="rounded-circle mb-3" alt="Foto Profil">
                        </div>
                        <div class="col-md-8">
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">{{ $user->name }}</dd>
                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $user->email }}</dd>
                                <dt class="col-sm-4">No HP</dt>
                                <dd class="col-sm-8">{{ $perawat->no_hp ?? '-' }}</dd>
                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">{{ $perawat->alamat ?? '-' }}</dd>
                                <dt class="col-sm-4">Tanggal Lahir</dt>
                                <dd class="col-sm-8">{{ $perawat->tanggal_lahir ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                    <a href="#" class="btn btn-secondary">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
