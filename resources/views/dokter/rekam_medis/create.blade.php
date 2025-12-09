@extends('layouts.lte.main')

@section('content')
<div class="container">
    <h1>Tambah Rekam Medis</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dokter.rekam_medis.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="pasien" class="form-label">Pasien</label>
                    <select name="pasien_id" id="pasien" class="form-control">
                        @foreach ($pasien as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="diagnosa" class="form-label">Diagnosa</label>
                    <textarea name="diagnosa" id="diagnosa" class="form-control" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection