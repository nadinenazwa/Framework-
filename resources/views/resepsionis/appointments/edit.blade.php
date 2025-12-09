@extends('layouts.lte.main')

@section('title', 'Edit Appointment')

@section('content')
<div class="container">
    <h1>Edit Appointment</h1>

    <form action="{{ route('resepsionis.appointments.update', $appointment->idreservasi_dokter) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Owner</label>
            <input type="text" class="form-control" value="{{ optional(optional($appointment->pet)->pemilik->user)->nama ?? optional($appointment->pet->pemilik)->no_wa ?? '-' }}" disabled>
        </div>

        <div class="mb-3">
            <label for="idpet" class="form-label">Pet</label>
            <select name="idpet" id="idpet" class="form-control">
                <option value="">-- Select Pet --</option>
                @foreach($pets ?? [] as $pet)
                    <option value="{{ $pet->idpet }}" {{ (old('idpet', $appointment->idpet) == $pet->idpet) ? 'selected' : '' }}>
                        {{ $pet->nama ?? ('Pet '.$pet->idpet) }} (ID: {{ $pet->idpet }})
                    </option>
                @endforeach
            </select>
            @error('idpet')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="idrole_user" class="form-label">Doctor</label>
            <select name="idrole_user" id="idrole_user" class="form-control">
                <option value="">-- Select Doctor --</option>
                @foreach($dokters ?? [] as $dok)
                    <option value="{{ $dok->idrole_user }}" {{ (old('idrole_user', $appointment->idrole_user) == $dok->idrole_user) ? 'selected' : '' }}>
                        {{ optional($dok->user)->nama ?? ('Dokter '.$dok->idrole_user) }}
                    </option>
                @endforeach
            </select>
            @error('idrole_user')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="waktu_daftar" class="form-label">Waktu Daftar</label>
            <input type="text" class="form-control" value="{{ optional($appointment->waktu_daftar)->format('Y-m-d H:i') ?? '-' }}" disabled>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('resepsionis.appointments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
