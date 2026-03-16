<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayCredential extends Model
{
    protected $table = 'gateway_credentials';
    protected $fillable = [
        'email',
        'token',
    ];
    public $timestamps = false;
}
