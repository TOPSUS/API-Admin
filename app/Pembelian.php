<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_pembelian';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_jadwal', 'id_user', 'bukti', 'tanggal', 'status'
    ];

    public function jadwal() {
        return $this->belongsTo(Jadwal::class, 'id_jadwal');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detail() {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian');
    }

}
