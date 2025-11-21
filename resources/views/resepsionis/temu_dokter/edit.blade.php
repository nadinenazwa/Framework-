@extends('layouts.lte.main')

@section('title', 'Edit Reservasi Temu Dokter')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.temu-dokter.index') }}">Temu Dokter</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Reservasi</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Edit Reservasi</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('resepsionis.temu-dokter.update', $temuDokter->idreservasi_dokter) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="idpet" class="form-label">Pilih Pet <span class="text-danger">*</span></label>
                    <select name="idpet" id="idpet" class="form-select">
                        <option value="">-- Pilih Pet --</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->idpet }}" @selected(old('idpet', $temuDokter->idpet) == $pet->idpet)>
                                {{ $pet->nama }} - {{ $pet->pemilik->nama_pemilik ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="idrole_user" class="form-label">Pilih Dokter (opsional)</label>
                    <select name="idrole_user" id="idrole_user" class="form-select">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->idrole_user }}" @selected(old('idrole_user', $temuDokter->idrole_user) == $doctor->idrole_user)>
                                {{ $doctor->user->nama ?? $doctor->user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" @selected(old('status', $temuDokter->status) == '1')>Menunggu</option>
                        <option value="2" @selected(old('status', $temuDokter->status) == '2')>Dalam Proses</option>
                        <option value="3" @selected(old('status', $temuDokter->status) == '3')>Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="no_urut" class="form-label">No. Urut</label>
                    <input type="number" name="no_urut" id="no_urut" class="form-control" value="{{ old('no_urut', $temuDokter->no_urut) }}">
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('resepsionis.temu-dokter.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
