<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.products' => 'required|array',
            'data.products.*.product_id' => 'required|exists:products,id',
            'data.products.*.quantity' => 'required|integer|min:1',
            'data.client.name' => 'required|string',
            'data.client.email' => 'required|email',
            'data.client.card_number' => 'required|string',
            'data.client.cvv' => 'required|integer',
        ];
    }
}
