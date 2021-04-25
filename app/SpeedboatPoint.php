<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpeedboatPoint extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_speedboat_point';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_pembelian', 'id_speedboat', 'point'
    ];

    public function pembelian() {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function speedboat() {
        return $this->belongsTo(Speedboat::class, 'id_speedboat');
    }

    public function detailreward() {
        return $this->hasMany(DetailReward::class, 'id_speedboat_point');
    }
}
