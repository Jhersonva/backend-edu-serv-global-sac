<?php

namespace App\Http\Requests\Links;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLinksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|min:3|max:150',
            'description' => 'nullable|string',
            'url' => 'sometimes|url',
            'image' => 'nullable|image|max:2048', 
        ];
    }
}
