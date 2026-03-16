<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\CustomSessions;
use App\Models\Gateway;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class gatewayRepository
{
    public function editGateway($data)
    {
        $gateway = Gateway::find($data['gateway_id']);
        $gateway->update($data);

        return $gateway;
    }
}
