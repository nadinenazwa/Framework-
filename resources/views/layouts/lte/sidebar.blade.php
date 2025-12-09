<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="RSHP Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">RSHP</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            
            {{-- Definisi Logic Role di Awal agar HTML di bawah lebih bersih --}}
                @php
                    $user = auth()->user();
                    // Use the same acceptance logic as middleware: role name match (case-insensitive)
                    // and allow when pivot status is 1 or pivot/status not set.
                    $hasRole = function ($name) use ($user) {
                        if (! $user) return false;
                        // Ensure roles collection is available
                        $roles = $user->roles;
                        return $roles->contains(function ($role) use ($name) {
                            return strcasecmp($role->nama_role ?? '', $name) === 0
                                && (!isset($role->pivot) || !isset($role->pivot->status) || (int) $role->pivot->status === 1);
                        });
                    };

                    $isAdmin = $hasRole('Administrator');
                    $isResepsionis = $hasRole('Resepsionis');
                    $isPerawat = $hasRole('Perawat');
                    $isDokter = $hasRole('Dokter');
                    $isPemilik = $hasRole('Pemilik');
                @endphp

            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                {{-- ========================================================== --}}
                {{-- SECTION: ADMINISTRATOR --}}
                {{-- ========================================================== --}}
                @if($isAdmin)
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">MENU UTAMA</li>

                    {{-- Dropdown: Master Data --}}
                    <li class="nav-item {{ request()->routeIs('admin.jenish.*') || request()->routeIs('admin.rashewan.*') || request()->routeIs('admin.kategori.*') || request()->routeIs('admin.kategoriklinis.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.jenish.*') || request()->routeIs('admin.rashewan.*') || request()->routeIs('admin.kategori.*') || request()->routeIs('admin.kategoriklinis.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-database"></i>
                            <p>
                                Master Data
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.jenish.index') }}" class="nav-link {{ request()->routeIs('admin.jenish.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Jenis Hewan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.rashewan.index') }}" class="nav-link {{ request()->routeIs('admin.rashewan.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Ras Hewan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Kategori</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kategoriklinis.index') }}" class="nav-link {{ request()->routeIs('admin.kategoriklinis.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Kategori Klinis</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Dropdown: Manajemen User --}}
                    <li class="nav-item {{ request()->routeIs('admin.user.*') || request()->routeIs('admin.role.*') || request()->routeIs('admin.dokter.*') || request()->routeIs('admin.perawat.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.user.*') || request()->routeIs('admin.role.*') || request()->routeIs('admin.dokter.*') || request()->routeIs('admin.perawat.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>
                                Manajemen User
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.role.index') }}" class="nav-link {{ request()->routeIs('admin.role.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Role</p>
                                </a>
                            </li>
                            @if(Route::has('admin.dokter.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.dokter.index') }}" class="nav-link {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i> <p>Data Dokter</p>
                                </a>
                            </li>
                            @endif
                            @if(Route::has('admin.perawat.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.perawat.index') }}" class="nav-link {{ request()->routeIs('admin.perawat.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Data Perawat</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Dropdown: Pemilik & Pet (Admin) --}}
                    <li class="nav-item {{ request()->routeIs('admin.pemilik.*') || request()->routeIs('admin.pet.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.pemilik.*') || request()->routeIs('admin.pet.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-hearts"></i>
                            <p>
                                Pemilik & Pet
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.pemilik.index') }}" class="nav-link {{ request()->routeIs('admin.pemilik.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Data Pemilik</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pet.index') }}" class="nav-link {{ request()->routeIs('admin.pet.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Data Pet</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Dropdown: Pelayanan (Admin) --}}
                    <li class="nav-item {{ request()->routeIs('admin.rekam-medis.*') || request()->routeIs('admin.kodetindakanterapi.*') || request()->routeIs('admin.temu-dokter.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.rekam-medis.*') || request()->routeIs('admin.kodetindakanterapi.*') || request()->routeIs('admin.temu-dokter.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-hospital"></i>
                            <p>
                                Pelayanan
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.rekam-medis.index') }}" class="nav-link {{ request()->routeIs('admin.rekam-medis.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Rekam Medis</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kodetindakanterapi.index') }}" class="nav-link {{ request()->routeIs('admin.kodetindakanterapi.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Tindakan Terapi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.temu-dokter.index') }}" class="nav-link {{ request()->routeIs('admin.temu-dokter.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Temu Dokter</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- ========================================================== --}}
                {{-- SECTION: PERAWAT --}}
                {{-- ========================================================== --}}
                @if($isPerawat)
                    <li class="nav-header">PERAWAT</li>
                    <li class="nav-item">
                        <a href="{{ route('perawat.dashboard') }}" class="nav-link {{ request()->routeIs('perawat.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('perawat.antrian.*') || request()->routeIs('perawat.profil.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('perawat.antrian.*') || request()->routeIs('perawat.profil.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>
                                Menu Perawat
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('perawat.antrian.index') }}" class="nav-link {{ request()->routeIs('perawat.antrian.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Daftar Temu Dokter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('perawat.profil.show') }}" class="nav-link {{ request()->routeIs('perawat.profil.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Profil Saya</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- ========================================================== --}}
                {{-- SECTION: DOKTER --}}
                {{-- ========================================================== --}}
                @if($isDokter)
                    <li class="nav-header">DOKTER</li>
                    <li class="nav-item">
                        <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('dokter.profil.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('dokter.profil.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-clipboard2-pulse"></i>
                            <p>
                                Menu Dokter
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dokter.pasien.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Pemeriksaan Pasien</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dokter.profil.show') }}" class="nav-link {{ request()->routeIs('dokter.profil') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Profil Saya</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- ========================================================== --}}
                {{-- SECTION: RESEPSIONIS --}}
                {{-- ========================================================== --}}
                @if($isResepsionis)
                    <li class="nav-header">RESEPSIONIS</li>
                    <li class="nav-item">
                        <a href="{{ route('resepsionis.dashboard') }}" class="nav-link {{ request()->routeIs('resepsionis.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @php
                        $isResepActive = request()->routeIs('resepsionis.pemilik.*') || request()->routeIs('resepsionis.pet.*') || request()->routeIs('resepsionis.temu-dokter.*');
                    @endphp
                    
                    <li class="nav-item {{ $isResepActive ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isResepActive ? 'active' : '' }}">
                            <i class="nav-icon bi bi-pc-display-horizontal"></i>
                            <p>
                                Menu Resepsionis
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('resepsionis.owners.index') }}" class="nav-link {{ request()->routeIs('resepsionis.owners.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Kelola Owners</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('resepsionis.pets.index') }}" class="nav-link {{ request()->routeIs('resepsionis.pets.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Kelola Pets</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('resepsionis.appointments.index') }}" class="nav-link {{ request()->routeIs('resepsionis.appointments.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Kelola Appointments</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- ========================================================== --}}
                {{-- SECTION: PEMILIK --}}
                {{-- ========================================================== --}}
                @if($isPemilik)
                    <li class="nav-header">PEMILIK</li>
                    <li class="nav-item">
                        <a href="{{ Route::has('pemilik.dashboard') ? route('pemilik.dashboard') : '#' }}" class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @php
                        $isPemilikActive = request()->routeIs('pemilik.pet.*') || request()->routeIs('pemilik.temu-dokter.*') || request()->routeIs('pemilik.rekam-medis.*') || request()->routeIs('pemilik.profile') || request()->routeIs('pemilik.dashboard');
                    @endphp

                    <li class="nav-item {{ $isPemilikActive && !request()->routeIs('pemilik.dashboard') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $isPemilikActive && !request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>
                                Menu Pemilik
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(Route::has('pemilik.profile'))
                            <li class="nav-item">
                                <a href="{{ route('pemilik.profile') }}" class="nav-link {{ request()->routeIs('pemilik.profile') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Profil Saya</p>
                                </a>
                            </li>
                            @endif

                            @if(Route::has('pemilik.appointments'))
                            <li class="nav-item">
                                <a href="{{ route('pemilik.appointments') }}" class="nav-link {{ request()->routeIs('pemilik.appointments') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Jadwal Temu</p>
                                </a>
                            </li>
                            @endif

                            @if(Route::has('pemilik.medical_records'))
                            <li class="nav-item">
                                <a href="{{ route('pemilik.medical_records') }}" class="nav-link {{ request()->routeIs('pemilik.medical_records') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Rekam Medis</p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
            </nav>
    </div>
    </aside>