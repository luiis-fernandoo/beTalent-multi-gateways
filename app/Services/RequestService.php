<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class RequestService
{
    private $headers = [];
    public function setHeaders(array $headers, $append = true)
    {
        $this->headers = $headers;
        return $this;
    }

    public function send(string $url, $body, string $method = 'POST'): string
    {
        return (string)HTTP::send($method, $url, array_filter([
            'headers' => $this->headers,
            'json' => $body,
        ]))->getBody();
    }
}
