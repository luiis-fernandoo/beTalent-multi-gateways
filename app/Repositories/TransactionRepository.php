<?php

namespace App\Repositories;

use App\Models\CustomSessions;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
    public function createTransaction($data, $client, $gateway, $response)
    {
        $transaction = Transaction::create([
            'client_id' => $client->id,
            'gateway_id' => $gateway->id,
            'external_id' => $response->id,
            'status' => 'approved',
            'amount' => $data['request']['body']['amount'] ?? $data['request']['body']['valor'],
            'card_last_numbers' => $gateway->id == 1 ? substr((string)$data['request']['body']['cardNumber'], -4) : substr((string)$data['request']['body']['numeroCartao'], -4),
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s')
        ]);

        $dataToSync = collect($data['data']['products'])->mapWithKeys(function ($item) {
            return [$item['product_id'] => ['quantity' => $item['quantity']]];
        })->all();

        $transaction->products()->sync($dataToSync);

        return Transaction::with(['clients', 'products'])->find($transaction->id);
    }

    public function allTransactions()
    {
        return Transaction::with(['clients', 'products'])->orderBy('id', 'desc')->get();
    }

    public function transactionDetails($transaction)
    {
        return Transaction::with(['clients', 'products'])->find($transaction->id);
    }

    public function updateTransaction($transactionId, $data)
    {
        Transaction::find($transactionId)->update([
            'status' => $data->status ?? 'charged_back'
        ]);

        return Transaction::find($transactionId);
    }


}
