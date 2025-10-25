@extends('layouts.main')

@section('title', 'Home')

@section('content')
<div class="content-wrapper">

    <div class="home-section">
        <div class="home-left">
            <h2>Pendaftaran Online</h2>
            <p>Rumah Sakit Hewan Pendidikan Universitas Airlangga berinovasi untuk selalu meningkatkan kualitas pelayanan. Kini tersedia fitur pendaftaran online yang mempermudah Anda mendaftarkan hewan kesayangan.</p>
            <a href="#" class="home-btn">DAFTAR SEKARANG <i class="fas fa-arrow-right"></i></a>

            <h2>Informasi Jadwal Dokter Jaga</h2>
            <p>Dapatkan informasi terbaru mengenai jadwal dokter jaga di RSHP Universitas Airlangga agar Anda dapat merencanakan kunjungan dengan lebih baik.</p>
            <a href="#" class="home-btn">LIHAT JADWAL DOKTER <i class="fas fa-calendar-alt"></i></a>
        </div>
        <div class="home-right">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/rCfvZPECZvE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p style="text-align:center; margin-top:15px; font-style:italic; color:#777;">"Melayani dengan Hati, Merawat dengan Ilmu"</p>
        </div>
    </div>

    <section class="news-section">
        <h2>BERITA TERKINI</h2>
        <div class="scroll-container">
            <div class="scroll-item">
                <img src="{{ asset('image/berita1.jpg') }}" alt="Seminar dan Workshop Sitologi dan Histopatologi">
                <div class="news-content">
                    <h3>Seminar dan Workshop Sitologi dan Histopatologi</h3>
                    <p class="news-date">8 Agustus 2024</p>
                    <p>RSHP Unair menyelenggarakan seminar dan workshop mendalam...</p>
                    <a href="https://rshp.unair.ac.id/seminar-dan-workshop-sitologi-dan-histopatologi/" target="_blank" class="read-more">Read more...</a>
                </div>
            </div>
            <div class="scroll-item">
                <img src="{{ asset('image/berita2.jpg') }}" alt="Tim Satu Sehat Juara 1 Senam Bugar Airlangga">
                <div class="news-content">
                    <h3>Tim Satu Sehat Juara 1 Senam Bugar Airlangga</h3>
                    <p class="news-date">2 Agustus 2024</p>
                    <p>Selamat kepada Tim Satu Sehat RSHP Unair atas prestasinya...</p>
                    <a href="https://rshp.unair.ac.id/tim-satu-sehat-juara-1-senam-bugar-airlangga/" target="_blank" class="read-more">Read more...</a>
                </div>
            </div>
            <div class="scroll-item">
                <img src="{{ asset('image/berita3.jpg') }}" alt="Trial Endolaparoskopi Persiapan Workshop di RSHP Unair">
                <div class="news-content">
                    <h3>Trial Endolaparoskopi Persiapan Workshop di RSHP Unair</h3>
                    <p class="news-date">26 Juli 2024</p>
                    <p>RSHP Unair melakukan uji coba endolaparoskopi sebagai persiapan...</p>
                    <a href="https://rshp.unair.ac.id/trial-endolaparoskopi-persiapan-workshop-di-rshp-unair/" target="_blank" class="read-more">Read more...</a>
                </div>
            </div>
        </div>
    </section>

    <section class="location-section">
        <h2>Lokasi Kami</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.519208035071!2d112.79373971477543!3d-7.291702894747065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fa689b7b961f%3A0xc0d7159756b10d7a!2sRumah%20Sakit%20Hewan%20Pendidikan%20Universitas%20Airlangga!5e0!3m2!1sid!2sid!4v1678873286789!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

</div>
@endsection