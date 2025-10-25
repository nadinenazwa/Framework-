<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisHewanController extends Controller
{
    public function index()
    {
        // Ambil data (untuk memastikan query tidak gagal)
        $jenisHewan = \App\Models\JenisHewan::all();
        return view('admin.JenisHewan.index', compact('jenisHewan'));
    }
}