@extends('layouts.lte.main')

@section('title', 'Buat Reservasi Temu Dokter')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.temu-dokter.index') }}">Temu Dokter</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buat Reservasi</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Buat Reservasi Temu Dokter</h5>
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

            <form action="{{ route('resepsionis.temu-dokter.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="idpet" class="form-label">Pilih Pet <span class="text-danger">*</span></label>
                    <select name="idpet" id="idpet" class="form-select">
                        <option value="">-- Pilih Pet --</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->idpet }}" @selected(old('idpet') == $pet->idpet)>
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
                            <option value="{{ $doctor->idrole_user }}" @selected(old('idrole_user') == $doctor->idrole_user)>
                                {{ $doctor->user->nama ?? $doctor->user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status (opsional)</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" @selected(old('status') == '1')>Menunggu</option>
                        <option value="2" @selected(old('status') == '2')>Dalam Proses</option>
                        <option value="3" @selected(old('status') == '3')>Selesai</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('resepsionis.temu-dokter.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
