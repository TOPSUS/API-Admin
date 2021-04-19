<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    //
    protected $table = 'tb_golongan';

    protected $fillable = [
        'id_pelabuhan', 'golongan', 'harga'
    ];

    public function detail() {
        return $this->hasMany(DetailGolongan::class, 'id_golongan');
    }
}
