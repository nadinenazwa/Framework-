@extends('layouts.lte.main')

@section('title', 'Edit Pet')

@section('content')
<div class="container">
    <h1>Edit Pet</h1>

    <form action="{{ route('resepsionis.pets.update', $pet->idpet) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Name</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pet->nama) }}">
            @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Birthdate</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($pet->tanggal_lahir)->format('Y-m-d')) }}">
            @error('tanggal_lahir')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Gender</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                <option value="J" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'J' ? 'selected' : '' }}>Jantan</option>
                <option value="B" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'B' ? 'selected' : '' }}>Betina</option>
            </select>
            @error('jenis_kelamin')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="idpemilik" class="form-label">Owner</label>
            <select name="idpemilik" id="idpemilik" class="form-control">
                <option value="">-- Select Owner --</option>
                @foreach($owners ?? [] as $owner)
                    <option value="{{ $owner->idpemilik }}" {{ (old('idpemilik', $pet->idpemilik) == $owner->idpemilik) ? 'selected' : '' }}>
                        {{ optional($owner->user)->nama ?? $owner->no_wa }} (ID: {{ $owner->idpemilik }})
                    </option>
                @endforeach
            </select>
            @error('idpemilik')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="idras_hewan" class="form-label">Breed</label>
            <select name="idras_hewan" id="idras_hewan" class="form-control">
                <option value="">-- Select Breed --</option>
                @foreach($breeds ?? [] as $b)
                    <option value="{{ $b->idras_hewan }}" {{ (old('idras_hewan', $pet->idras_hewan) == $b->idras_hewan) ? 'selected' : '' }}>{{ $b->nama_ras }}</option>
                @endforeach
            </select>
            @error('idras_hewan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="warna_tanda" class="form-label">Warna Tanda</label>
            <input type="text" name="warna_tanda" id="warna_tanda" class="form-control" value="{{ old('warna_tanda', $pet->warna_tanda) }}" maxlength="255">
            @error('warna_tanda')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('resepsionis.pets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
