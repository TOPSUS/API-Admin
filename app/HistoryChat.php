<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryChat extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tb_history_chat';
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'message', 'jawaban', 'tanggal', 'status'
    ];
}
