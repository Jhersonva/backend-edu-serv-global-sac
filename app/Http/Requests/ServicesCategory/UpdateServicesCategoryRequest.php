<?php

namespace App\Http\Requests\ServicesCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicesCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'benefits' => ['nullable', 'array'],
            'benefits.*' => ['string'],
            'id_projects' => ['sometimes', 'exists:projects,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
