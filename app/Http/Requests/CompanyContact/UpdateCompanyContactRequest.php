<?php

namespace App\Http\Requests\CompanyContact;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => 'sometimes|string|max:250',
            'phone' => 'sometimes|string|max:15',
            'email' => 'sometimes|email',
            'url_map' => 'sometimes|string',
            'cordenadas_map' => 'sometimes|string',
        ];
    }
}
