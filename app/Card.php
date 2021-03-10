<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_card';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'card'
    ];

    public function detailpembelian() {
        return $this->hasMany(DetailPembelian::class, 'id_card');
    }
}
