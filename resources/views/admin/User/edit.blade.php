@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
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

                    <form action="{{ route('admin.user.update', $user->iduser) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('nama')) ? 'is-invalid' : '' }}" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama', $user->nama) }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('email')) ? 'is-invalid' : '' }}" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('password')) ? 'is-invalid' : '' }}" 
                                   id="password" 
                                   name="password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation">
                        </div>

                        <div class="form-group mb-3">
                            <label for="idrole">Role <span class="text-danger">*</span></label>
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('idrole')) ? 'is-invalid' : '' }}" 
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
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            @php
                                $currentStatus = old('status', $user->roles->first()?->pivot->status ?? 'nonaktif');
                            @endphp
                            <select class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('status')) ? 'is-invalid' : '' }}" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif" {{ $currentStatus == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $currentStatus == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
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
