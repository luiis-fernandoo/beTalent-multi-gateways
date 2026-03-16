<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomSessions extends Model
{
    protected $table = 'custom_sessions';
    protected $fillable = [
        'user_id',
        'token',
        'ip_address',
        'expiration_token'
    ];
    public $timestamps = false;
}
