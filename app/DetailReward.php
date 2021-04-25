<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailReward extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_detail_reward';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_speedboat_point', 'id_speedboat_reward', 'alamat'
    ];

    public function speedboatpoint() {
        return $this->belongsTo(SpeedboatPoint::class, 'id_speedboat_point');
    }

    public function reward() {
        return $this->belongsTo(Reward::class, 'id_speedboat_reward');
    }
}
