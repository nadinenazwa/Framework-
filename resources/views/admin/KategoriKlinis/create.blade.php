@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Kategori Klinis</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(isset($errors) && is_object($errors) && $errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.kategoriklinis.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nama_kategori_klinis">Nama Kategori Klinis <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control {{ (isset($errors) && is_object($errors) && $errors->has('nama_kategori_klinis')) ? 'is-invalid' : '' }}" 
                                   id="nama_kategori_klinis" 
                                   name="nama_kategori_klinis" 
                                   value="{{ old('nama_kategori_klinis') }}" 
                                   placeholder="Masukkan Nama Kategori Klinis"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategoriklinis.index') }}" class="btn btn-secondary">
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
