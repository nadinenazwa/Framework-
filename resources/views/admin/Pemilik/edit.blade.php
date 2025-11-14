@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3>Edit Pemilik</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li><a href="{{ route('admin.pemilik.index') }}">Pemilik</a></li>
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
                        <h3 class="card-title">Form Edit Pemilik</h3>
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

                        <form action="{{ route('admin.pemilik.update', $pemilik->idpemilik) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="iduser" class="form-label">User <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('iduser')) ? 'is-invalid' : '' }}" 
                                        id="iduser" 
                                        name="iduser" 
                                        required>
                                    <option value="">-- Pilih User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->iduser }}" {{ old('iduser', $pemilik->iduser) == $user->iduser ? 'selected' : '' }}>
                                            {{ $user->nama }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('iduser'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('iduser') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="no_wa" class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('no_wa')) ? 'is-invalid' : '' }}" 
                                       id="no_wa" 
                                       name="no_wa" 
                                       value="{{ old('no_wa', $pemilik->no_wa) }}" 
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('no_wa'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('no_wa') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('alamat')) ? 'is-invalid' : '' }}" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="4" 
                                          required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                                @if(isset($errors) && is_object($errors) && $errors->has('alamat'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('alamat') }}
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">
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
