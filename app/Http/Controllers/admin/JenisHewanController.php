<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Exception; 

class JenisHewanController extends Controller
{
    /**
     * Menampilkan daftar jenis hewan.
     */
    public function index()
    {
        $jenisHewan = DB::table('jenis_hewan')
            ->select('idjenis_hewan', 'nama_jenis_hewan')
            ->get();
            
        return view('admin.JenisHewan.index', compact('jenisHewan'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('admin.JenisHewan.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_hewan' => 'required|string|max:100',
        ]);

        try {
            DB::table('jenis_hewan')->insert([
                'nama_jenis_hewan' => $request->nama_jenis_hewan,
                // 'status' => 1, // Anda bisa tambahkan field lain jika perlu
            ]);

            return redirect()->route('admin.jenish.index')
                             ->with('success', 'Data jenis hewan berhasil disimpan.');
        } catch (Exception $e) {
            // throw new Exception('Gagal menyimpan data jenis hewan: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit($id)
    {
        // Query Builder
        $jenisHewan = DB::table('jenis_hewan')
            ->where('idjenis_hewan', $id)
            ->first();

        if (!$jenisHewan) {
            return redirect()->route('admin.jenish.index')
                             ->with('error', 'Data tidak ditemukan.');
        }
        return view('admin.JenisHewan.edit', compact('jenisHewan'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis_hewan' => 'required|string|max:100',
        ]);

        try {
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->update([
                    'nama_jenis_hewan' => $request->nama_jenis_hewan,
                ]);

            return redirect()->route('admin.jenish.index')
                             ->with('success', 'Data jenis hewan berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data dari database.
     * Menggunakan Query Builder 'delete'.
     */
    public function destroy($id)
    {
        try {
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->delete();

            return redirect()->route('admin.jenish.index')
                             ->with('success', 'Data jenis hewan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.jenish.index')
                             ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}