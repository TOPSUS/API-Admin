<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes;

    protected $table = 'tb_user';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nama', 'alamat', 'jeniskelamin', 'nohp', 'email', 'chat_id', 'pin',
        'password', 'foto', 'role', 'token_login', 'fcm_token', 'id_speedboat'
    ];
}
