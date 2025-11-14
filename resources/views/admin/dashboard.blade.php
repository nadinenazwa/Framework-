@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Users</h6>
                                <h2 class="mb-0">{{ $totalUsers }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary bg-opacity-25">
                        <small><a href="{{ route('admin.user.index') }}" class="text-white text-decoration-none">Lihat Detail <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Pet</h6>
                                <h2 class="mb-0">{{ $totalPets }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-25">
                        <small><a href="{{ route('admin.pet.index') }}" class="text-white text-decoration-none">Lihat Detail <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Pemilik</h6>
                                <h2 class="mb-0">{{ $totalOwners }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-warning bg-opacity-25">
                        <small><a href="{{ route('admin.pemilik.index') }}" class="text-white text-decoration-none">Lihat Detail <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-2">Total Role</h6>
                                <h2 class="mb-0">{{ $totalRoles }}</h2>
                            </div>
                            <div style="font-size: 2.5rem; opacity: 0.3;">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-danger bg-opacity-25">
                        <small><a href="{{ route('admin.role.index') }}" class="text-white text-decoration-none">Lihat Detail <i class="bi bi-arrow-right"></i></a></small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Terbaru</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>Nama User</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentUsers as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info">{{ $role->nama_role }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @php
                                                $status = $user->roles->first()?->pivot->status ?? 0;
                                            @endphp
                                            @if($status == 1 || $status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Tidak ada data user</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistik Jenis Hewan</h3>
                    </div>
                    <div class="card-body">
                        <div id="animal-chart" style="height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ApexCharts for animal statistics
        try {
            var options = {
                chart: { type: 'donut', height: 300 },
                series: [{{ $totalUsers }}, {{ $totalPets }}, {{ $totalOwners }}, {{ $totalRoles }}],
                labels: ['Users', 'Pets', 'Pemilik', 'Roles'],
                colors: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
            };
            var chart = new ApexCharts(document.querySelector('#animal-chart'), options);
            chart.render();
        } catch (e) { console.warn('ApexCharts not loaded', e); }
    });
</script>

@endsection

