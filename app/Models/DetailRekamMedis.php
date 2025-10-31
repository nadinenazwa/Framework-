<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRekamMedis extends Model
{
    use HasFactory;

    protected $table = 'detail_rekam_medis';
    protected $primaryKey = 'iddetail_rekam_medis';
    public $timestamps = false; // Asumsi tidak ada created_at/updated_at

    protected $fillable = [
        'idrekam_medis',
        'idkode_tindakan_terapi',
        'detail',
    ];

    /**
     * Get the rekam medis that owns the detail.
     */
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }

    /**
     * Get the tindakan/terapi (kode_tindakan_terapi) for this detail.
     */
    public function tindakanTerapi()
    {
        // Menghubungkan ke tabel 'kode_tindakan_terapi'
        return $this->belongsTo(KodeTindakanTerapi::class, 'idkode_tindakan_terapi', 'idkode_tindakan_terapi');
    }
}