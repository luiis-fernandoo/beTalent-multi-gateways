<?php

namespace Database\Seeders;

use App\Models\Gateway;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GatewaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gateway::create([
            'name' => 'Gateway 1',
            'is_active' => '1',
            'priority' => '1',
        ]);

        Gateway::create([
            'name' => 'Gateway 2',
            'is_active' => '1',
            'priority' => '2',
        ]);
    }
}
