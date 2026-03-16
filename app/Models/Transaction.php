<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'client_id', 'gateway_id', 'amount',
        'external_id', 'status', 'card_last_numbers',
        'created_at', 'updated_at'
    ];
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_products')
            ->withPivot('quantity');
    }

    public function clients(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
