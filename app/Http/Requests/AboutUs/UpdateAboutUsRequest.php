<?php

namespace App\Http\Requests\AboutUs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'sometimes|required|string',
            'mission' => 'sometimes|required|string',
            'vision' => 'sometimes|required|string',
            'history' => 'sometimes|required|string',
            'values' => 'sometimes|required|array',
            'video_url' => 'nullable|url',
            'video_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
