<?php

namespace App\Http\Requests\ServicesCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicesCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'benefits' => ['nullable', 'array'],
            'benefits.*' => ['string'],
            'id_projects' => ['required', 'exists:projects,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
