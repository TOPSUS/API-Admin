<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes;

    protected $table = 'tb_user';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama', 'alamat', 'jeniskelamin', 'nohp', 'email', 'chat_id', 'pin',
        'password', 'foto', 'role', 'token_login', 'id_speedboat'
    ];

    public function speedboat() {
        return $this->belongsTo(Speedboat::class, 'id_speedboat');
    }

    public function pembelian() {
        return $this->hasMany(Pembelian::class, 'id_pembelian');
    }

    public function beritaspeedboat() {
        return $this->hasMany(BeritaSpeedboat::class, 'id_user');
    }

    public function beritapelabuhan() {
        return $this->hasMany(BeritaPelabuhan::class, 'id_user');
    }
}
