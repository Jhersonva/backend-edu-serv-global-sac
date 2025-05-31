<?php

namespace App\Http\Requests\TeamInformation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string|min:3|max:255',
            'rol' => 'sometimes|string|min:3|max:150',
            'description' => 'sometimes|string|min:3',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
