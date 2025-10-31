@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perawat Dashboard</h1>
    <p>Welcome to the Perawat Dashboard, {{ session('user_name') }}!</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pets</h5>
                    <p class="card-text">View pets information</p>
                    <a href="{{ route('admin.pet.index') }}" class="btn btn-primary">View Pets</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pemilik</h5>
                    <p class="card-text">View pet owners</p>
                    <a href="{{ route('admin.pemilik.index') }}" class="btn btn-primary">View Pemilik</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kategori Klinis</h5>
                    <p class="card-text">View clinical categories</p>
                    <a href="{{ route('admin.kategoriklinis.index') }}" class="btn btn-primary">View Kategori Klinis</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kode Tindakan Terapi</h5>
                    <p class="card-text">View therapy action codes</p>
                    <a href="{{ route('admin.kodetindakanterapi.index') }}" class="btn btn-primary">View Kode Tindakan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
