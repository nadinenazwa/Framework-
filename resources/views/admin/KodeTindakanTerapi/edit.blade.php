@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Kode Tindakan Terapi</h4>
                </div>
                <div class="card-body">
                    @if(isset($errors) && is_object($errors) && $errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.kodetindakanterapi.update', $kodeTindakanTerapi->idkode_tindakan_terapi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="kode">Kode <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('kode')) ? 'is-invalid' : '' }}" 
                                   id="kode" 
                                   name="kode" 
                                   value="{{ old('kode', $kodeTindakanTerapi->kode) }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi_tindakan_terapi">Deskripsi Tindakan Terapi <span class="text-danger">*</span></label>
                            <textarea class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('deskripsi_tindakan_terapi')) ? 'is-invalid' : '' }}" 
                                      id="deskripsi_tindakan_terapi" 
                                      name="deskripsi_tindakan_terapi" 
                                      rows="4" 
                                      required>{{ old('deskripsi_tindakan_terapi', $kodeTindakanTerapi->deskripsi_tindakan_terapi) }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="idkategori">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('idkategori')) ? 'is-invalid' : '' }}" 
                                    id="idkategori" 
                                    name="idkategori" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->idkategori }}" {{ old('idkategori', $kodeTindakanTerapi->idkategori) == $kat->idkategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="idkategori_klinis">Kategori Klinis <span class="text-danger">*</span></label>
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('idkategori_klinis')) ? 'is-invalid' : '' }}" 
                                    id="idkategori_klinis" 
                                    name="idkategori_klinis" 
                                    required>
                                <option value="">-- Pilih Kategori Klinis --</option>
                                @foreach($kategoriKlinis as $katKlinis)
                                    <option value="{{ $katKlinis->idkategori_klinis }}" {{ old('idkategori_klinis', $kodeTindakanTerapi->idkategori_klinis) == $katKlinis->idkategori_klinis ? 'selected' : '' }}>
                                        {{ $katKlinis->nama_kategori_klinis }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kodetindakanterapi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
