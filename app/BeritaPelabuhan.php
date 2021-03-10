<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeritaPelabuhan extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_berita_pelabuhan';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_user', 'id_pelabuhan', 'berita', 'tanggal'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function speedboat() {
        return $this->belongsTo(Speedboat::class, 'id_speedboat');
    }
}
