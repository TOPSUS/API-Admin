<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelabuhan extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_pelabuhan';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'kode_pelabuhan', 'nama_pelabuhan', 'lokasi_pelabuhan', 'alamat_kantor', 'latitude',
        'longtitude', 'lama_beroperasi', 'status'
    ];

    public function jadwalasal() {
        return $this->hasMany(Jadwal::class, 'id_asal_pelabuhan');
    }

    public function jadwaltujuan() {
        return $this->hasMany(Jadwal::class, 'id_tujuan_pelabuhan');
    }

    public function jadwal() {
        $data = collect([$this->jadwalasal, $this->jadwaltujuan]);
        return $data;
    }
}
