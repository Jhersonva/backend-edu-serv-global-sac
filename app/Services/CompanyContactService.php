<?php

namespace App\Services;

use App\Models\CompanyContact;

class CompanyContactService
{
    public function getAllCompanyContact()
    {
        return CompanyContact::all();
    }

    public function findCompanyContactById($id)
    {
        return CompanyContact::findOrFail($id);
    }

    public function storeCompanyContact(array $data)
    {
        return CompanyContact::create([
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'url_map' => $data['url_map'],
            'cordenadas_map' => $data['cordenadas_map'],
        ]);
    }

    public function updateCompanyContact($id, array $data)
    {
        $companyContact = CompanyContact::findOrFail($id);

        $companyContact->update([
            'address' => $data['address'] ?? $companyContact->address,
            'phone' => $data['phone'] ?? $companyContact->phone,
            'email' => $data['email'] ?? $companyContact->email,
            'url_map' => $data['url_map'] ?? $companyContact->url_map,
            'cordenadas_map' => $data['cordenadas_map'] ?? $companyContact->cordenadas_map,
        ]);

        return $companyContact;
    }

    public function deleteCompanyContact($id): bool
    {
        $companyContact = CompanyContact::findOrFail($id);
        return $companyContact->delete();
    }
}
