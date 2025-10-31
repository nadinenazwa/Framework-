@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Admin Dashboard, {{ session('user_name') }}!</p>

    <!-- Management Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Manage system users</p>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Roles</h5>
                    <p class="card-text">Manage user roles</p>
                    <a href="{{ route('admin.role.index') }}" class="btn btn-primary">Manage Roles</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jenis Hewan</h5>
                    <p class="card-text">Manage animal types</p>
                    <a href="{{ route('admin.jenish.index') }}" class="btn btn-primary">Manage Jenis Hewan</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ras Hewan</h5>
                    <p class="card-text">Manage animal breeds</p>
                    <a href="{{ route('admin.rashewan.index') }}" class="btn btn-primary">Manage Ras Hewan</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pemilik</h5>
                    <p class="card-text">Manage pet owners</p>
                    <a href="{{ route('admin.pemilik.index') }}" class="btn btn-primary">Manage Pemilik</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pets</h5>
                    <p class="card-text">Manage pets</p>
                    <a href="{{ route('admin.pet.index') }}" class="btn btn-primary">Manage Pets</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kategori</h5>
                    <p class="card-text">Manage categories</p>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary">Manage Kategori</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kategori Klinis</h5>
                    <p class="card-text">Manage clinical categories</p>
                    <a href="{{ route('admin.kategoriklinis.index') }}" class="btn btn-primary">Manage Kategori Klinis</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kode Tindakan Terapi</h5>
                    <p class="card-text">Manage therapy action codes</p>
                    <a href="{{ route('admin.kodetindakanterapi.index') }}" class="btn btn-primary">Manage Kode Tindakan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
