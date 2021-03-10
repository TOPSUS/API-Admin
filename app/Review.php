<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_review';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_pembelian', 'id_speedboat', 'review', 'score'
    ];

    public function pembelian() {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function speedboat() {
        return $this->belongsTo(Speedboat::class, 'id_speedboat');
    }
}
