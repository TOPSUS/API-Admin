<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_jadwal';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'waktu_berangkat', 'id_asal_pelabuhan', 'id_tujuan_pelabuhan', 'estimasi_waktu', 'id_kapal', 'tanggal', 'harga'
    ];

    public function pelabuhanasal() {
        return $this->belongsTo(Pelabuhan::class, 'id_asal_pelabuhan');
    }

    public function pelabuhantujuan() {
        return $this->belongsTo(Pelabuhan::class, 'id_tujuan_pelabuhan');
    }

    public function kapal() {
        return $this->belongsTo(Kapal::class, 'id_kapal');
    }

    public function pembelian() {
        return $this->hasMany(Pembelian::class, 'id_jadwal');
    }

}
