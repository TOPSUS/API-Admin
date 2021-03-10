<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reward extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_reward_speedboat';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_speedboat', 'reward', 'berlaku', 'minimal_point', 'foto'
    ];

    public function speedboat() {
        return $this->belongsTo(Speedboat::class, 'id_speedboat');
    }

    public function detail() {
        return $this->hasMany(DetailReward::class, 'id_speedboat_reward');
    }
}
