<?php

namespace App\Http\Requests\ContactForm;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string|min:3|max:150',
            'email' => 'sometimes|string',
            'message' => 'sometimes|string',
        ];
    }
}
