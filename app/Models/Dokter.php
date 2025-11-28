<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';
    public $timestamps = false; // Ubah ke true jika tabel punya created_at/updated_at
    protected $fillable = [
        'iduser',
        'id_dokter', 
        'bidang_dokter',
        'jenis_kelamin',
        'no_hp',
        'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}