<?php

namespace App\Http\Requests;

class AdjustStockRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer',
            'reason' => 'nullable|string|max:255',
        ];
    }
}
