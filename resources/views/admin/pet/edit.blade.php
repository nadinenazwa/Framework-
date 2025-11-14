@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3>Edit Pet</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li><a href="{{ route('admin.pet.index') }}">Pet</a></li>
                    <li class="active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Pet</h3>
                    </div>
                    <div class="card-body">
                        @if(isset($errors) && is_object($errors) && $errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.pet.update', $pet->idpet) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama Pet <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('nama')) ? 'is-invalid' : '' }}" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $pet->nama) }}" 
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('nama'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('nama') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('tanggal_lahir')) ? 'is-invalid' : '' }}" 
                                       id="tanggal_lahir" 
                                       name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', $pet->tanggal_lahir ? $pet->tanggal_lahir->format('Y-m-d') : '') }}" 
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('tanggal_lahir'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('tanggal_lahir') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="warna_tanda" class="form-label">Warna/Tanda <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('warna_tanda')) ? 'is-invalid' : '' }}" 
                                       id="warna_tanda" 
                                       name="warna_tanda" 
                                       value="{{ old('warna_tanda', $pet->warna_tanda) }}" 
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('warna_tanda'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('warna_tanda') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('jenis_kelamin')) ? 'is-invalid' : '' }}" 
                                        id="jenis_kelamin" 
                                        name="jenis_kelamin" 
                                        required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="jantan" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'jantan' ? 'selected' : '' }}>Jantan</option>
                                    <option value="betina" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'betina' ? 'selected' : '' }}>Betina</option>
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('jenis_kelamin'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('jenis_kelamin') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="idpemilik" class="form-label">Pemilik <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('idpemilik')) ? 'is-invalid' : '' }}" 
                                        id="idpemilik" 
                                        name="idpemilik" 
                                        required>
                                    <option value="">-- Pilih Pemilik --</option>
                                    @foreach($pemilik as $p)
                                        <option value="{{ $p->idpemilik }}" {{ old('idpemilik', $pet->idpemilik) == $p->idpemilik ? 'selected' : '' }}>
                                            {{ $p->user->nama ?? 'Unknown' }} - {{ $p->no_wa }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('idpemilik'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('idpemilik') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="idras_hewan" class="form-label">Ras Hewan <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('idras_hewan')) ? 'is-invalid' : '' }}" 
                                        id="idras_hewan" 
                                        name="idras_hewan" 
                                        required>
                                    <option value="">-- Pilih Ras Hewan --</option>
                                    @foreach($rasHewan as $ras)
                                        <option value="{{ $ras->idras_hewan }}" {{ old('idras_hewan', $pet->idras_hewan) == $ras->idras_hewan ? 'selected' : '' }}>
                                            {{ $ras->nama_ras }} ({{ $ras->jenisHewan->nama_jenis_hewan ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('idras_hewan'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('idras_hewan') }}
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Batal
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
