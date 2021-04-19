<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HakAksesKapal extends Model
{
    use SoftDeletes;
    //
    protected $table = 'tb_hak_akses_kapal';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_user', 'id_kapal', 'hak_akses'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kapal() {
        return $this->belongsTo(Kapal::class, 'id_kapal');
    }
}
