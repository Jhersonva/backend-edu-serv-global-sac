<?php

namespace App\Http\Requests\Collaborations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollaborationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|min:3|max:150',
            'url' => 'sometimes|url',
            'image' => 'nullable|image|max:2048', 
        ];
    }
}
