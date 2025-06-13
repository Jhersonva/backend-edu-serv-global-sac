<?php

namespace App\Http\Requests\Links;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'description' => 'required|string',
            'url' => 'required|url',
            'image' => 'nullable|image|max:2048', 
        ];
    }
}
