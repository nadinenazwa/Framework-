<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'iduser';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
            ->withPivot('status');
    }

    public function roleUser()
    {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }
    
    // --- RELASI TAMBAHAN ---
    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'iduser', 'iduser');
    }

    public function perawat()
    {
        return $this->hasOne(Perawat::class, 'iduser', 'iduser');
    }

    /**
     * Cek apakah user memiliki role 'dokter'.
     */
    public function isDokter()
    {
        return $this->roles()->where('nama_role', 'dokter')->exists();
    }

    /**
     * Cek apakah user memiliki role 'perawat'.
     */
    public function isPerawat()
    {
        return $this->roles()->where('nama_role', 'perawat')->exists();
    }

    /**
     * Cek apakah user memiliki role 'admin'.
     */

    public function isAdministrator()
    {
        return $this->roles()->where('nama_role', 'admin')->exists();
    }
}
