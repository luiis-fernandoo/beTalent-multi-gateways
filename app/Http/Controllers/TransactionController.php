<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => (new TransactionService())->listAllTransactions()
        ]);
    }

    public function store(TransactionRequest $request)
    {
        try {
            $response = (new TransactionService())->mountDataToProccessTransation($request->validated());
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([$response]);
    }

    public function show(Transaction $transaction)
    {
        return response()->json([
            'success' => true,
            'data' => (new TransactionRepository())->transactionDetails($transaction)
        ]);
    }

    public function chargeBack($transactionId)
    {
        try{
            $response = (new TransactionService())->chargeBackTransaction($transactionId);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'success' => !collect($response)->has('error') ? true : false,
            'data' => $response
        ]);
    }
}
