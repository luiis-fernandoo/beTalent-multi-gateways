<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clothes = [
            ['name' => 'Camiseta Algodão Egípcio Minimalista', 'amount' => 12990,],
            ['name' => 'Calça Jeans Selvedge Slim Fit', 'amount' => 34900,],
            ['name' => 'Jaqueta Corta-Vento Repelente à Água', 'amount' => 28950,],
            ['name' => 'Moletom Oversized Heavyweight', 'amount' => 19990,],
            ['name' => 'Tênis Casual em Couro Legítimo', 'amount' => 45000,],
            ['name' => 'Bermuda Sarja Premium com Elastano', 'amount' => 15900,],
            ['name' => 'Camisa Social Linho Manga Longa', 'amount' => 21000,],
            ['name' => 'Kit 3 Pares de Meias Performance', 'amount' => 5990]
        ];

        Product::insert($clothes);
    }
}
