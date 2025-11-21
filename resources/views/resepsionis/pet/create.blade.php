@extends('layouts.lte.main')

@section('title', 'Tambah Hewan Peliharaan')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Hewan Peliharaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-plus-circle"></i> Tambah Hewan Peliharaan Baru
            </h2>
            <p class="text-muted">Daftarkan hewan peliharaan baru ke dalam sistem</p>
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
                <i class="bi bi-clipboard-check"></i> Form Hewan Peliharaan
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('resepsionis.pet.store') }}" method="POST" id="petForm">
                @csrf

                <!-- Pet Owner -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-person"></i> Pilih Pemilik
                    </h6>
                    <div class="mb-3">
                        <label for="idpemilik" class="form-label">
                            <span class="badge bg-danger">Wajib</span> Pemilik
                        </label>
                        <select name="idpemilik" id="idpemilik" class="form-select @error('idpemilik') is-invalid @enderror" required>
                            <option value="">-- Pilih Pemilik --</option>
                            @foreach($pemilik as $p)
                                <option value="{{ $p->idpemilik }}" @selected(old('idpemilik') == $p->idpemilik)>
                                    {{ $p->nama_pemilik }} ({{ $p->user->email ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('idpemilik')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pet Information -->
                <div class="mb-4 p-3 border rounded bg-light">
                    <h6 class="mb-3">
                        <i class="bi bi-paw"></i> Informasi Hewan Peliharaan
                    </h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_hewan" class="form-label">
                                <span class="badge bg-danger">Wajib</span> Nama Hewan
                            </label>
                            <input type="text" name="nama_hewan" id="nama_hewan" 
                                   class="form-control @error('nama_hewan') is-invalid @enderror"
                                   placeholder="Contoh: Fluffy, Max, Bella..." value="{{ old('nama_hewan') }}" required>
                            @error('nama_hewan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="warna" class="form-label">
                                <span class="badge bg-warning">Opsional</span> Warna
                            </label>
                            <input type="text" name="warna" id="warna" 
                                   class="form-control @error('warna') is-invalid @enderror"
                                   placeholder="Contoh: Putih, Hitam, Coklat..." value="{{ old('warna') }}">
                            @error('warna')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="idjenis_hewan" class="form-label">
                                <span class="badge bg-danger">Wajib</span> Jenis Hewan
                            </label>
                            <select name="idjenis_hewan" id="idjenis_hewan" class="form-select @error('idjenis_hewan') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($jenisHewan as $jenis)
                                    <option value="{{ $jenis->idjenis_hewan }}" @selected(old('idjenis_hewan') == $jenis->idjenis_hewan)>
                                        {{ $jenis->nama_jenis_hewan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idjenis_hewan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="idras_hewan" class="form-label">
                                <span class="badge bg-danger">Wajib</span> Ras Hewan
                            </label>
                            <select name="idras_hewan" id="idras_hewan" class="form-select @error('idras_hewan') is-invalid @enderror" required>
                                <option value="">-- Pilih Ras --</option>
                                @foreach($rasHewan as $ras)
                                    <option value="{{ $ras->idras_hewan }}" @selected(old('idras_hewan') == $ras->idras_hewan)>
                                        {{ $ras->nama_ras }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idras_hewan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="umur" class="form-label">
                                <span class="badge bg-warning">Opsional</span> Umur (tahun)
                            </label>
                            <input type="number" name="umur" id="umur" step="0.1" min="0"
                                   class="form-control @error('umur') is-invalid @enderror"
                                   placeholder="Contoh: 2, 3.5, 5..." value="{{ old('umur') }}">
                            @error('umur')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="berat_badan" class="form-label">
                                <span class="badge bg-warning">Opsional</span> Berat Badan (kg)
                            </label>
                            <input type="number" name="berat_badan" id="berat_badan" step="0.1" min="0"
                                   class="form-control @error('berat_badan') is-invalid @enderror"
                                   placeholder="Contoh: 5, 15.5, 20..." value="{{ old('berat_badan') }}">
                            @error('berat_badan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Simpan
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
        const form = document.getElementById('petForm');

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
