@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3>Edit User</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li><a href="{{ route('admin.user.index') }}">User</a></li>
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
                        <h3 class="card-title">Form Edit User</h3>
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

                        <form action="{{ route('admin.user.update', $user->iduser) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('nama')) ? 'is-invalid' : '' }}" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $user->nama) }}" 
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('nama'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('nama') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('email')) ? 'is-invalid' : '' }}" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @if(isset($errors) && is_object($errors) && $errors->has('email'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                <input type="password" 
                                       class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('password')) ? 'is-invalid' : '' }}" 
                                       id="password" 
                                       name="password">
                                @if(isset($errors) && is_object($errors) && $errors->has('password'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                            </div>

                            <div class="form-group mb-3">
                                <label for="idrole" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('idrole')) ? 'is-invalid' : '' }}" 
                                        id="idrole" 
                                        name="idrole" 
                                        required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($roles as $role)
                                        @php
                                            $userRole = $user->roles->first();
                                            $selected = old('idrole', $userRole?->idrole) == $role->idrole;
                                        @endphp
                                        <option value="{{ $role->idrole }}" {{ $selected ? 'selected' : '' }}>
                                            {{ $role->nama_role }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('idrole'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('idrole') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                @php
                                    $currentStatus = old('status', $user->roles->first()?->pivot->status ?? 'nonaktif');
                                @endphp
                                <select class="form-select {{ (isset($errors) && is_object($errors) && $errors->has('status')) ? 'is-invalid' : '' }}" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="aktif" {{ $currentStatus == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ $currentStatus == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @if(isset($errors) && is_object($errors) && $errors->has('status'))
                                    <div class="invalid-feedback d-block">
                                        {{ $errors->first('status') }}
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
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
