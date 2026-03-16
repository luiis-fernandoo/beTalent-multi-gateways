<?php

namespace App\Contracts;

Interface GatewayInterface{
    public function getHeaders(): array;
    public function getBaseUrl(array $data): string;
    public function mountCredentials();
    public function mountDataToSend(array $data);
    public function sendRequestToGateway(array $data);
    public function sendRequestToGatewayChargeBack(array $data);
}
