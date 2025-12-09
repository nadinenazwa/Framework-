<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    public $timestamps = false;
    use HasFactory, SoftDeletes;

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
        // `rekam_medis` table does not have `idpet`; pet is derived via `temu_dokter`.
        'anamnesa',
        'temuan_klinis',
        'diagnosa',
        'dokter_pemeriksa',
        'idreservasi_dokter',
        'deleted_by',
    ];

    /**
     * Pet is derived through the related `temuDokter` (appointment).
     * Access via `$rekamMedis->pet` to get the Pet model when available.
     */
    public function getPetAttribute()
    {
        return $this->temuDokter ? $this->temuDokter->pet : null;
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

    /**
     * Soft-delete child details when this RekamMedis is soft-deleted,
     * and restore them when RekamMedis is restored.
     */
    protected static function booted()
    {
        static::deleting(function ($model) {
            if (!method_exists($model, 'isForceDeleting') || !$model->isForceDeleting()) {
                $model->detailRekamMedis()->get()->each(function ($detail) {
                    if (method_exists($detail, 'delete')) {
                        $detail->delete();
                    }
                });
            }
        });

        static::restoring(function ($model) {
            // restore related details (including trashed)
            if (method_exists($model->detailRekamMedis(), 'withTrashed')) {
                $model->detailRekamMedis()->withTrashed()->get()->each(function ($detail) {
                    if (method_exists($detail, 'restore')) {
                        $detail->restore();
                    }
                });
            }
        });

        // NOTE: Previously there was a created() hook here which automatically
        // updated the related TemuDokter status to a textual value like
        // 'selesai'. That behavior caused the appointment to be marked
        // completed as soon as a Perawat created a RekamMedis. Per the new
        // workflow, the reservation status must remain pending when a
        // Perawat creates the RekamMedis. The status update to "completed"
        // must happen only when a Dokter finishes input (handled in the
        // Dokter controller). Therefore the created hook was intentionally
        // removed.
    }
}

