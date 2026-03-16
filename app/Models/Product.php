<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'amount'
    ];
    public $timestamps = false;

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'products_transactions');
    }
}
