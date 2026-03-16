<?php

namespace App\Services\Gateways;

use App\Contracts\GatewayInterface;

class GatewayProvider
{
    public static function getService(string $slug)
    {
        return match ($slug) {
            'gateway_1' => new Gateway1Service(),
            'gateway_2' => new Gateway2Service(),

            default => throw new \Exception("Serviço de gateway não encontrado para: {$slug}"),
        };
    }
}
