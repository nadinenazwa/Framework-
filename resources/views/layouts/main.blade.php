<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - RSHP Universitas Airlangga</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('head')
</head>
<body>
    <div class="page-wrapper">
        <header class="main-header">
            <div class="logo-container">
                <img class="logo-unair" src="{{ asset('image/Logo (2).png') }}" alt="Logo UNAIR">
                <h1>RUMAH SAKIT HEWAN PENDIDIKAN<br><span>UNIVERSITAS AIRLANGGA</span></h1>
                <img class="logo-unair" src="{{ asset('image/RSHP.png') }}" alt="Logo RSHP">
            </div>
        </header>

        <nav class="main-nav">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/struktur') }}">Struktur Organisasi</a></li>
                <li><a href="{{ url('/layanan') }}">Layanan Umum</a></li>
                <li><a href="{{ url('/visimisi') }}">Visi Misi & Tujuan</a></li>
                <li><a href="{{ url('/login') }}">Login</a></li>
            </ul>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>

        <footer class="app-footer">
            <div class="footer-content">
                <div class="footer-section contact-info">
                    <h3>Kontak Kami</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Mulyorejo, Kec. Mulyorejo, Surabaya</p>
                    <p><i class="fas fa-phone-alt"></i> (031) 5928581</p>
                    <p><i class="fas fa-envelope"></i> info@rshp.unair.ac.id</p>
                </div>
                <div class="footer-section social-media">
                    <h3>Ikuti Kami</h3>
                    <a href="https://www.facebook.com/share/1EbGvj1DsE/?mibextid=wwXIfr" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/rshp.unair?igsh=aXhwN3drYjEzaWJv" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@rshpuniversitasairlangga3636" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="footer-section quick-links">
                    <h3>Link Cepat</h3>
                    <ul>
                        <li><a href="{{ url('/layanan') }}">Layanan Kami</a></li>
                        <li><a href="{{ url('/struktur') }}">Struktur Organisasi</a></li>
                        <li><a href="{{ url('/visimisi') }}">Visi Misi & Tujuan</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date("Y") }} RSHP Universitas Airlangga. Semua Hak Dilindungi.</p>
            </div>
        </footer>
    </div>
</body>
</html>