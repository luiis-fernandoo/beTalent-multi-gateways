<?php

namespace App\Services\Gateways;

use App\Contracts\GatewayInterface;
use App\Models\Product;
use App\Services\RequestService;

class Gateway1Service implements GatewayInterface
{
    public function getHeaders(): array {
        return [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
            'Authorization' => "Bearer " . (new Gateway1Service())->mountCredentials(),
        ];
    }

    public function mountCredentials()
    {
        $credentialsToLogin = [
            'email' => config('services.gateways.gateway_1.email'),
            'token' => config('services.gateways.gateway_1.token')
        ];

        return json_decode((new RequestService())->setHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->send(config('services.gateways.gateway_1.url') . 'login', $credentialsToLogin))->token ?? null;
    }

    public function getBaseUrl(): string {
        return config("services.gateways.gateway_1.url");
    }

    public function mountDataToSend(array $data): array
    {
        return [
            'headers' => $this->getHeaders(),
            'body' => [
                'amount' => $this->sumAllProducts($data['products']),
                'name' => $data['client']['name'],
                'email' => $data['client']['email'],
                'cardNumber' => $data['client']['card_number'],
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
            $this->getBaseUrl() . 'transactions',
            $data['body']
        ));
    }

    public function sendRequestToGatewayChargeBack($data)
    {
        return json_decode((new RequestService())->setHeaders($this->getHeaders())->send(
            $this->getBaseUrl() . 'transactions/' . $data['external_id'] . '/charge_back',
            [])
        );
    }

    public function getAllTransactions()
    {
        return json_decode((new RequestService())->setHeaders($this->getHeaders())->send(
            $this->getBaseUrl() . 'transactions/',
            [], 'GET')
        );
    }
}
