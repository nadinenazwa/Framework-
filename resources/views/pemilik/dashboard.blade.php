@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pemilik Dashboard</h1>
    <p>Welcome to the Pemilik Dashboard, {{ session('user_name') }}!</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My Pets</h5>
                    <p class="card-text">View and manage your pets</p>
                    <a href="{{ route('pemilik.pets.index') }}" class="btn btn-primary">View My Pets</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">View and update your profile</p>
                    <a href="{{ route('pemilik.profile') }}" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Appointments</h5>
                    <p class="card-text">View your appointments</p>
                    <a href="{{ route('pemilik.appointments.index') }}" class="btn btn-primary">View Appointments</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Medical Records</h5>
                    <p class="card-text">View medical records for your pets</p>
                    <a href="{{ route('pemilik.medical-records.index') }}" class="btn btn-primary">View Records</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
