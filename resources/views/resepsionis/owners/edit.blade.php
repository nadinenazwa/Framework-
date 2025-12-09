@extends('layouts.lte.main')

@section('title', 'Edit Owner')

@section('content')
<div class="container">
    <h1>Edit Owner</h1>

    <form action="{{ route('resepsionis.owners.update', $owner->idpemilik) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="no_wa" class="form-label">No WA</label>
            <input type="text" name="no_wa" id="no_wa" class="form-control" value="{{ old('no_wa', $owner->no_wa) }}">
            @error('no_wa')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $owner->alamat) }}</textarea>
            @error('alamat')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', optional($owner->user)->nama) }}">
            @error('nama')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', optional($owner->user)->email) }}" placeholder="owner@example.com">
            <div class="form-text">Masukkan email untuk membuat/menautkan user pemilik.</div>
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('resepsionis.owners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
