<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Gateway;
use App\Models\Product;
use App\Models\Transaction;
use App\Repositories\ClientRepository;
use App\Repositories\TransactionRepository;
use App\Services\Gateways\Gateway1Service;
use App\Services\Gateways\GatewayProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionService
{
    public function listAllTransactions()
    {
        $gatewaysToSend = Gateway::Where('is_active', 1)->orderBy('priority', 'ASC')->get();
        $responses = [];

        foreach($gatewaysToSend as $gateway){
            $gatewaySlug = Str::slug($gateway->name, '_');
            $service = GatewayProvider::getService($gatewaySlug);
            $responses[$gatewaySlug] = $service->getAllTransactions();
        }

        return $responses;

    }
    public function mountDataToProccessTransation($transaction)
    {
        $gatewaysToSend = Gateway::Where('is_active', 1)->orderBy('priority', 'ASC')->get();
        $responses = [];
        $transactionSuccess = false;

        DB::beginTransaction();

        foreach($gatewaysToSend as $gateway){
            $gatewaySlug = Str::slug($gateway->name, '_');
            $service = GatewayProvider::getService($gatewaySlug);
            $data = $service->mountDataToSend($transaction['data']);
            $data['gateway'] = $gatewaySlug;
            $transaction['request'] = $data;
            $response = $service->sendRequestToGateway($data);
            $responses['gateways'][$gatewaySlug] = $response;

            if(collect($response)->has('id')){
                $transactionSuccess = true;
                $client = (new ClientRepository())->createClient($transaction['data']['client']);
                $transaction = (new TransactionRepository())->createTransaction($transaction, $client, $gateway, $response);

                $responses['gateways'][$gatewaySlug] = $transaction;
                break;
            }
        }

        DB::commit();
        return [
            'success' => $transactionSuccess,
            'data' => $responses
        ];
    }

    public function chargeBackTransaction($transactionId)
    {
        $transaction = Transaction::find($transactionId);

        if($transaction->status != 'approved'){
            return [
                'error' => 'Não é possível reembolsar uma compra inválida!'
            ];
        }

        $gateway = Gateway::find($transaction->gateway_id);

        if(!$gateway->is_active == 1){
            return [
                'error' => 'Gateway não disponível!'
            ];
        }

        $gatewaySlug = Str::slug($gateway->name, '_');
        $service = GatewayProvider::getService($gatewaySlug);

        $data = [
            'gateway' => $gatewaySlug,
            'external_id' => $transaction->external_id
        ];

        $response = $service->sendRequestToGatewayChargeBack($data);

        if(!collect($response)->has('error')){
            return (new TransactionRepository())->updateTransaction($transactionId, $response);
        }

        return $response;
    }
}
