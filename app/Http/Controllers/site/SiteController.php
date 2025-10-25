<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{ public function index()
    {
        return view('site.home');
    }

    public function cekKoneksi()
    {
        try {
            \DB::connection()->getPdo();
            return "Koneksi database berhasil!";
        } catch (\Exception $e) {
            return "Koneksi database gagal: " . $e->getMessage();
        }
    }

    public function strukturOrganisasi()
    {
        return view('site.struktur');
    }

    public function layananUmum()
    {
        return view('site.layanan');
    }

    public function visiMisi()
    {
        return view('site.visi_misi');
    }

    public function login()
    {
        return view('site.login');
    }
}