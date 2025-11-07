@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Role</h3>
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

                    <form action="{{ route('admin.role.update', $role->idrole) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="nama_role">Nama Role <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('nama_role')) ? 'is-invalid' : '' }}" 
                                   id="nama_role" 
                                   name="nama_role" 
                                   value="{{ old('nama_role', $role->nama_role) }}" 
                                   required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">
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
