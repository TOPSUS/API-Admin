<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speedboat extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_speedboat';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama_speedboat', 'kapasitas', 'deskripsi', 'foto', 'contact_service',
        'tanggal_beroperasi'
    ];

    public function user() {
        return $this->hasMany(User::class, 'id_speedboat');
    }
    
    public function speedboatpoint() {
        return $this->hasMany(SpeedboatPoint::class, 'id_speedboat');
    }
    
    public function reward() {
        return $this->hasMany(Reward::class, 'id_speedboat');
    }

    public function review() {
        return $this->hasMany(Review::class, 'id_speedboat');
    }

    public function beritaspeedboat() {
        return $this->hasMany(BeritaSpeedboat::class, 'id_speedboat');
    }

    public function beritapelabuhan() {
        return $this->hasMany(BeritaPelabuhan::class, 'id_speedboat');
    }
}
