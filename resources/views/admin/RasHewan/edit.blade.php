@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Ras Hewan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.rashewan.index') }}">Ras Hewan</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Ras Hewan</h3>
                    </div>
                    <div class="card-body">
                        @if(isset($errors) && is_object($errors) && $errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Validasi Error!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.rashewan.update', $rasHewan->idras_hewan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="nama_ras" class="form-label">Nama Ras <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('nama_ras')) ? 'is-invalid' : '' }}" 
                                       id="nama_ras" 
                                       name="nama_ras" 
                                       value="{{ old('nama_ras', $rasHewan->nama_ras) }}" 
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('nama_ras'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('nama_ras') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="idjenis_hewan" class="form-label">Jenis Hewan <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('idjenis_hewan')) ? 'is-invalid' : '' }}" 
                                        id="idjenis_hewan" 
                                        name="idjenis_hewan" 
                                        required>
                                    <option value="">-- Pilih Jenis Hewan --</option>
                                    @foreach($jenisHewan as $jenis)
                                        <option value="{{ $jenis->idjenis_hewan }}" {{ old('idjenis_hewan', $rasHewan->idjenis_hewan) == $jenis->idjenis_hewan ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis_hewan }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('idjenis_hewan'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('idjenis_hewan') }}
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('admin.rashewan.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
