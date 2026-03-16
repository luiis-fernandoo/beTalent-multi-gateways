<?php

namespace App\Repositories;

use App\Models\CustomSessions;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductRepository
{
    public function createProduct($data)
    {
        return Product::create($data);
    }

    public function updateProduct($data, $productId)
    {
        Product::where('id', $productId)->update($data);

        return Product::find($productId);
    }

    public function destroyProduct($productId)
    {
        return Product::find($productId)->delete();
    }
}
