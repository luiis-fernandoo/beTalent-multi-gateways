<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'email',
    ];
    public $timestamps = false;

    public function transactions(){
        return $this->hasMany(Transaction::class, 'client_id');
    }
}
