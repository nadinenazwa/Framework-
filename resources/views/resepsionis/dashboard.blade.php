@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resepsionis Dashboard</h1>
    <p>Welcome to the Resepsionis Dashboard, {{ session('user_name') }}!</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pemilik</h5>
                    <p class="card-text">Manage pet owners</p>
                    <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-primary">Manage Pemilik</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pets</h5>
                    <p class="card-text">Manage pets</p>
                    <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-primary">Manage Pets</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Temu Dokter</h5>
                    <p class="card-text">Manage Temu Dokter</p>
                    <a href="{{ route('resepsionis.temu_dokter.index') }}" class="btn btn-primary">Manage Temu Dokter</a>
                </div>
            </div>
        </div>
    <div>
</div>
@endsection
