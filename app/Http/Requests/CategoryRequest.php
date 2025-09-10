<?php

namespace App\Http\Requests;

class CategoryRequest extends BaseApiRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
		];
	}
}
