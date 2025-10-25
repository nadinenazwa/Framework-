@extends('layouts.main')

@section('title', 'Layanan Umum')

@section('content')
<div class="main-card">
    <h1 style="font-size: 2.5em; margin-bottom: 30px;">Layanan Kami</h1>

    <div class="service-grid">
        <div class="service-card">
            <div class="icon"><i class="fas fa-paw"></i></div>
            <h3>Poliklinik Hewan Kecil</h3>
        </div>

        <div class="service-card">
            <div class="icon"><i class="fas fa-horse"></i></div>
            <h3>Poliklinik Hewan Besar</h3>
        </div>

        <div class="service-card">
            <div class="icon"><i class="fas fa-microscope"></i></div>
            <h3>Laboratorium Diagnostik</h3>
        </div>

        <div class="service-card">
            <div class="icon"><i class="fas fa-cut"></i></div>
            <h3>Bedah Hewan</h3>
        </div>

        <div class="service-card">
            <div class="icon"><i class="fas fa-bed"></i></div>
            <h3>Rawat Inap</h3>
        </div>

        <div class="service-card">
            <div class="icon"><i class="fas fa-first-aid"></i></div>
            <h3>Unit Gawat Darurat</h3>
        </div>
    </div>

</div>
@endsection