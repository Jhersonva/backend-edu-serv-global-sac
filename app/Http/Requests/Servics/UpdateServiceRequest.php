<?php

namespace App\Http\Requests\Servics;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //'category_id' => 'sometimes|exists:categories,id',
            'sub_category_id' => 'sometimes|exists:sub_categories,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|min:10',
            'benefits' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}

