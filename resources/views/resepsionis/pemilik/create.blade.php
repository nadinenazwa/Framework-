@extends('layouts.lte.main')

@section('title', 'Tambah Pemilik')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.pemilik.index') }}">Pemilik</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-plus-circle"></i> Tambah Pemilik Baru
            </h2>
            <p class="text-muted">Daftarkan pemilik hewan baru ke dalam sistem</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">
                <i class="bi bi-exclamation-triangle"></i> Validation Error!
            </h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-check"></i> Form Pendaftaran Pemilik
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('resepsionis.pemilik.store') }}" method="POST" id="pemilikForm">
                @csrf

                <!-- Personal Information -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-person"></i> Informasi Pribadi
                    </h6>

                    <div class="mb-3">
                        <label for="nama_pemilik" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Nama Lengkap
                        </label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" 
                               class="form-control @error('nama_pemilik') is-invalid @enderror"
                               placeholder="Contoh: Budi Santoso..." value="{{ old('nama_pemilik') }}" required>
                        @error('nama_pemilik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label">
                                <span class="badge bg-danger">Wajib</span> No. Telepon
                            </label>
                            <input type="text" name="no_hp" id="no_hp" 
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   placeholder="Contoh: +628123456789 atau 08123456789" 
                                   value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                Format: Diawali +62 atau 0, minimal 9-12 digit
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="form-label">
                                <span class="badge bg-danger">Wajib</span> Alamat
                            </label>
                            <input type="text" name="alamat" id="alamat" 
                                   class="form-control @error('alamat') is-invalid @enderror"
                                   placeholder="Contoh: Jl. Merdeka No. 123, Jakarta..." 
                                   value="{{ old('alamat') }}" required>
                            @error('alamat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-lock"></i> Informasi Akun
                    </h6>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Email
                        </label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Contoh: budi@email.com" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-2">
                            Email akan digunakan untuk login
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <span class="badge bg-danger">Wajib</span> Password
                            </label>
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                <span class="badge bg-danger">Wajib</span> Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Ulangi password" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Daftarkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('pemilikForm');

        // Form validation
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
@endsection
