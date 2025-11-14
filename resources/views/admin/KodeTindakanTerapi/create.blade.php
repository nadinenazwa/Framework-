@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3>Tambah Kode Tindakan Terapi</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li><a href="{{ route('admin.kodetindakanterapi.index') }}">Kode Tindakan Terapi</a></li>
                    <li class="active">Tambah</li>
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
                        <h3 class="card-title">Form Tambah Kode Tindakan Terapi</h3>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

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

                        <form action="{{ route('admin.kodetindakanterapi.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="kode" class="form-label">Kode Tindakan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('kode')) ? 'is-invalid' : '' }}" 
                                       id="kode" 
                                       name="kode" 
                                       value="{{ old('kode') }}" 
                                       placeholder="Contoh: T001, K001"
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('kode'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('kode') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="deskripsi_tindakan_terapi" class="form-label">Deskripsi Tindakan Terapi <span class="text-danger">*</span></label>
                                <textarea class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('deskripsi_tindakan_terapi')) ? 'is-invalid' : '' }}" 
                                          id="deskripsi_tindakan_terapi" 
                                          name="deskripsi_tindakan_terapi" 
                                          rows="4" 
                                          placeholder="Contoh: Pemeriksaan rutin kesehatan hewan"
                                          required>{{ old('deskripsi_tindakan_terapi') }}</textarea>
                                @if(isset($errors) && is_object($errors) && $errors->has('deskripsi_tindakan_terapi'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('deskripsi_tindakan_terapi') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="idkategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('idkategori')) ? 'is-invalid' : '' }}" 
                                        id="idkategori" 
                                        name="idkategori" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->idkategori }}" {{ old('idkategori') == $kat->idkategori ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('idkategori'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('idkategori') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="idkategori_klinis" class="form-label">Kategori Klinis <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('idkategori_klinis')) ? 'is-invalid' : '' }}" 
                                        id="idkategori_klinis" 
                                        name="idkategori_klinis" 
                                        required>
                                    <option value="">-- Pilih Kategori Klinis --</option>
                                    @foreach($kategoriKlinis as $katKlinis)
                                        <option value="{{ $katKlinis->idkategori_klinis }}" {{ old('idkategori_klinis') == $katKlinis->idkategori_klinis ? 'selected' : '' }}>
                                            {{ $katKlinis->nama_kategori_klinis }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('idkategori_klinis'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('idkategori_klinis') }}
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('admin.kodetindakanterapi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Simpan
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
