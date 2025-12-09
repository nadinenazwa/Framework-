@extends('layouts.lte.main')

@section('title', 'Edit Profil Pemilik')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded px-3 py-2">
            <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pemilik.profil') }}">Profil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-1">
                <i class="bi bi-pencil"></i> Edit Profil Pemilik
            </h2>
            <p class="text-muted">Perbarui informasi profil Anda</p>
        </div>
    </div>

    @include('pemilik.profile.edit')