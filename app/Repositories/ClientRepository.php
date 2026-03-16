<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\CustomSessions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClientRepository
{
    public function createClient($data)
    {
        $client = Client::where('email', $data['email'])->first();

        if($client->exists()){
            return $client;
        }

        return Client::create($data);
    }

    public function clientDetails(Client $client)
    {
        return $client->load(['transactions' => function ($query) {
            $query->with('products')->select('id', 'client_id', 'amount');
        }]);
    }
}
