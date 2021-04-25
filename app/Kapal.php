<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kapal extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_kapal';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama_kapal', 'kapasitas', 'deskripsi', 'foto', 'contact_service',
        'tanggal_beroperasi', 'tipe_kapal'
    ];

    public function hakAkses() {
        return $this->hasMany(HakAksesKapal::class, 'id_kapal');
    }

    public function detailGolongan() {
        return $this->hasOne(DetailGolongan::class, 'id_kapal');
    }
}
