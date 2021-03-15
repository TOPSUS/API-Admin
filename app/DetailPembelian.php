<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPembelian extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_detail_pembelian';
    
    protected $primaryKey = 'id_detail_pembelian';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_pembelian', 'id_card', 'kode_tiket', 'nama_pemegang_tiket', 'no_id_card',
        'harga', 'QRCode', 'status'
    ];

    public function pembelian() {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function card() {
        return $this->belongsTo(Card::class, 'id_card');
    }
}
