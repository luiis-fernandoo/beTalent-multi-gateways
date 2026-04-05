<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteAccess extends Model
{
    use HasFactory;

    protected $table = 'route_access';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_id',
        'route',
        'http_method',
    ];
    public $timestamps = false;
}
