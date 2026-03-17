<?php

namespace App\Services\Gateways;

use App\Models\Product;
use App\Services\RequestService;

class Gateway2Service
{
    public function getHeaders(): array {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            'Gateway-Auth-Token' => config('services.gateways.gateway_2.Gateway-Auth-Token'),
            'Gateway-Auth-Secret' => config('services.gateways.gateway_2.Gateway-Auth-Secret'),
        ];
    }

    public function getBaseUrl(): string {
        return config("services.gateways.gateway_2.url");
    }

    public function mountDataToSend(array $data)
    {
        return [
            'headers' => $this->getHeaders(),
            'body' => [
                'valor' => $this->sumAllProducts($data['products']),
                'nome' => $data['client']['name'],
                'email' => $data['client']['email'],
                'numeroCartao' => $data['client']['card_number'],
                'cvv' => $data['client']['cvv'],
            ]
        ];
    }

    private function sumAllProducts($products)
    {
        $value = null;

        foreach($products as $product){
            $valueProduct = Product::find($product['product_id'])->amount;
            $productPrice = $valueProduct * $product['quantity'];
            $value += $productPrice;
        }

        return (int) $value;
    }

    public function sendRequestToGateway($data)
    {
        return json_decode((new RequestService())->setHeaders($data['headers'])->send(
            $this->getBaseUrl() . 'transacoes',
            $data['body']
        ));
    }

    public function sendRequestToGatewayChargeBack($data)
    {
        return json_decode((new RequestService())->setHeaders($this->getHeaders())->send(
            $this->getBaseUrl() . 'transacoes/reembolso',
            ['id' => $data['external_id']])
        );
    }

    public function getAllTransactions()
    {
        return json_decode((new RequestService())->setHeaders($this->getHeaders())->send(
            $this->getBaseUrl() . 'transacoes/',
            [], 'GET')
        );
    }
}
