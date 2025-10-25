@extends('layouts.main')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="main-card org-chart">
    <h1 class="org-title">STRUKTUR ORGANISASI<br>RUMAH SAKIT HEWAN PENDIDIKAN<br>UNIVERSITAS AIRLANGGA</h1>

    <div class="org-level">
        <div class="org-member">
            <p><b>DIREKTUR</b></p>
            <img src="{{ asset('image/Direktur.jpg') }}" alt="Direktur">
            <p><b>Dr. drh. Susi Taufanilawaty, M.Si., drh.</b></p>
        </div>
    </div>

    <div class="org-level org-deputies-level">
        <div class="org-member">
            <p><b>WAKIL DIREKTUR I<br>PELAYANAN MEDIS, PENDIDIKAN DAN PENELITIAN</b></p>
            <img src="{{ asset('image/Wadirut 1.jpg') }}" alt="Wadir 1">
            <p><b>Dr. Noefiarno Trisakti, M.Si., drh.</b></p>
        </div>
        <div class="org-member">
            <p><b>WAKIL DIREKTUR II<br>SUMBER DAYA MANUSIA, SARANA PRASARANA DAN KEUANGAN</b></p>
            <img src="{{ asset('image/Wadirut 2.jpg') }}" alt="Wadir 2">
            <p><b>Dr. Mimy Sasmita S., M.Med., drh.</b></p>
        </div>
    </div>
</div>
@endsection