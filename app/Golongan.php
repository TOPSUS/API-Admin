<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Golongan extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_golongan';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_pelabuhan', 'golongan', 'harga'
    ];

    public function detail() {
        return $this->hasMany(DetailGolongan::class, 'id_golongan');
    }
}
