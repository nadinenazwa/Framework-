@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pet</h3>
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

                    <form action="{{ route('admin.pet.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nama">Nama Pet <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('nama')) ? 'is-invalid' : '' }}" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama') }}" 
                                   placeholder="Contoh: Brownie, Kitty"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('tanggal_lahir')) ? 'is-invalid' : '' }}" 
                                   id="tanggal_lahir" 
                                   name="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir') }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="warna_tanda">Warna/Tanda <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('warna_tanda')) ? 'is-invalid' : '' }}" 
                                   id="warna_tanda" 
                                   name="warna_tanda" 
                                   value="{{ old('warna_tanda') }}" 
                                   placeholder="Contoh: Coklat, Putih belang hitam"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('jenis_kelamin')) ? 'is-invalid' : '' }}" 
                                    id="jenis_kelamin" 
                                    name="jenis_kelamin" 
                                    required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="jantan" {{ old('jenis_kelamin') == 'jantan' ? 'selected' : '' }}>Jantan</option>
                                <option value="betina" {{ old('jenis_kelamin') == 'betina' ? 'selected' : '' }}>Betina</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="idpemilik">Pemilik <span class="text-danger">*</span></label>
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('idpemilik')) ? 'is-invalid' : '' }}" 
                                    id="idpemilik" 
                                    name="idpemilik" 
                                    required>
                                <option value="">-- Pilih Pemilik --</option>
                                @foreach($pemilik as $p)
                                    <option value="{{ $p->idpemilik }}" {{ old('idpemilik') == $p->idpemilik ? 'selected' : '' }}>
                                        {{ $p->user->nama ?? 'Unknown' }} - {{ $p->no_wa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="idras_hewan">Ras Hewan <span class="text-danger">*</span></label>
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('idras_hewan')) ? 'is-invalid' : '' }}" 
                                    id="idras_hewan" 
                                    name="idras_hewan" 
                                    required>
                                <option value="">-- Pilih Ras Hewan --</option>
                                @foreach($rasHewan as $ras)
                                    <option value="{{ $ras->idras_hewan }}" {{ old('idras_hewan') == $ras->idras_hewan ? 'selected' : '' }}>
                                        {{ $ras->nama_ras }} ({{ $ras->jenisHewan->nama_jenis_hewan ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
