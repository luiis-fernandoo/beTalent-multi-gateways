<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Client::all()
        ]);
    }

    public function show(Client $client)
    {
        return response()->json([
            'success' => true,
            'data' => (new ClientRepository())->clientDetails($client)
        ]);
    }
}
