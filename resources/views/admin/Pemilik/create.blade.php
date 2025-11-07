@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pemilik</h3>
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

                    <form action="{{ route('admin.pemilik.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="iduser">User <span class="text-danger">*</span></label>
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('iduser')) ? 'is-invalid' : '' }}" 
                                    id="iduser" 
                                    name="iduser" 
                                    required>
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->iduser }}" {{ old('iduser') == $user->iduser ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_wa">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('no_wa')) ? 'is-invalid' : '' }}" 
                                   id="no_wa" 
                                   name="no_wa" 
                                   value="{{ old('no_wa') }}" 
                                   placeholder="Contoh: 08123456789"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('alamat')) ? 'is-invalid' : '' }}" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="4" 
                                      placeholder="Masukkan alamat lengkap"
                                      required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">
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
