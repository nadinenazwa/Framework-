<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rekam_medis';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idrekam_medis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'anamnesa',
        'temuan_klinis',
        'diagnosa',
        'dokter_pemeriksa',
        'idreservasi_dokter',
    ];

    /**
     * Get the pet that owns the rekam medis.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    /**
     * Get the temu dokter that owns the rekam medis.
     */
    public function temuDokter()
    {
        return $this->belongsTo(TemuDokter::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }

    public function dokterPemeriksa()
    {
        // Relasi ini menghubungkan kolom 'dokter_pemeriksa' di tabel 'rekam_medis'
        // ke kolom 'idrole_user' di tabel 'role_user' (Model RoleUser).
        
        return $this->belongsTo(RoleUser::class, 'dokter_pemeriksa', 'idrole_user');
    }

    public function detailRekamMedis()
    {
        // Relasi ini menghubungkan ke model 'DetailRekamMedis'
        // Foreign key di 'detail_rekam_medis' adalah 'idrekam_medis'
        return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }
}

