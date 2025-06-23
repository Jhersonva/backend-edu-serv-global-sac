<?php

namespace App\Http\Requests\Collaborations;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollaborationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:150',
            'url' => 'required|url',
            'image' => 'nullable|image|max:2048', 
        ];
    }
}
