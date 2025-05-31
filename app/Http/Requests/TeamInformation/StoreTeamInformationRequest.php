<?php

namespace App\Http\Requests\TeamInformation;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamInformationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|min:3|max:255',
            'rol' => 'required|string|min:3|max:150',
            'description' => 'required|string|min:3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
