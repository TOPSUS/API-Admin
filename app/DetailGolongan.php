<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailGolongan extends Model
{
    //
    protected $table = 'tb_detail_golongan';

    protected $fillable = [
        'id_golongan', 'id_kapal', 'jumlah'
    ];

    public $timestamps = false;
    
    public function kapal() {
        return $this->belongsTo(Kapal::class, 'id_kapal');
    }

    public function golongan() {
        return $this->belongsTo(Golongan::class, 'id_golongan');
    }

}
