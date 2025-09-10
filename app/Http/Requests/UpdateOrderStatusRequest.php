<?php

namespace App\Http\Requests;

class UpdateOrderStatusRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ];
    }
}
