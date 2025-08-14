<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LegderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|string|min:0.01',
            'ledger_type' => 'required|in:payable,receivable',
            'shipping_id' => 'required|exists:shippings,id',
            'model_type' => 'required|string',
            'type_id' => 'required|integer',
            'paid_on' => 'required|date',
            'payment_method' => 'required|string',
            'remarks' => 'nullable|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
        ];
    }
}
