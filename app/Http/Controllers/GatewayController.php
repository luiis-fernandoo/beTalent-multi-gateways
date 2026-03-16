<?php

namespace App\Http\Controllers;

use App\Http\Requests\GatewayRequest;
use App\Repositories\gatewayRepository;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    public function gatewayStatus(GatewayRequest $request)
    {
        $data = $request->validated();

        return response()->json([
            'success' => true,
            'data' => (new gatewayRepository())->editGateway($data)
        ]);
    }
}
