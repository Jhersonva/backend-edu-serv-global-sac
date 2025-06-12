<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required', 'string', 'max:255',
            'description' => 'nullable', 'string',
            'id_services_category' => 'required', 'exists:services_categories,id',
            'image' => 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048',
        ];
    }
}
