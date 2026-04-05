<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\RouteAccess;
use Illuminate\Database\Seeder;

class RouteAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methodGroups = [
            'api_resource' => ['GET', 'POST', 'PUT', 'DELETE'],
            'read_only' => ['GET'],
        ];

        $accessMatrix = [
            'MANAGER' => [
                'product' => 'api_resource',
                'user' => 'api_resource',
                'transactions' => 'api_resource',
                'clients' => 'api_resource',
                'gateway-status' => 'api_resource',
            ],
            'FINANCE' => [
                'product' => 'api_resource',
                'change-back' => 'api_resource',
                'transactions' => 'api_resource',
                'clients' => 'api_resource',
                'gateway-status' => 'api_resource',
            ],
            'USER' => [
                'transactions' => 'api_resource',
                'clients' => 'api_resource',
                'gateway-status' => 'api_resource',
            ],
        ];

        $roles = Roles::query()
            ->whereIn('name', array_keys($accessMatrix))
            ->get()
            ->keyBy('name');

        foreach ($accessMatrix as $roleName => $routes) {
            $role = $roles->get($roleName);

            if (!$role) {
                continue;
            }

            foreach ($routes as $route => $methods) {
                $methods = is_array($methods)
                    ? $methods
                    : ($methodGroups[$methods] ?? []);

                foreach ($methods as $method) {
                    RouteAccess::firstOrCreate([
                        'role_id' => $role->id,
                        'route' => $route,
                        'http_method' => $method,
                    ]);
                }
            }
        }
    }
}
