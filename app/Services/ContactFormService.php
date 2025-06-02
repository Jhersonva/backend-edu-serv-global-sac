<?php

namespace App\Services;

use App\Models\ContactForm;

class ContactFormService
{
    public function getAllContactForm()
    {
        return ContactForm::all();
    }

    public function findContactFormById($id)
    {
        return ContactForm::findOrFail($id);
    }

    public function storeContactForm(array $data)
    {
        return ContactForm::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ]);
    }

    public function updateContactForm($id, array $data)
    {
        $contactform = ContactForm::findOrFail($id);

        $contactform->update([
            'full_name' => $data['full_name'] ?? $contactform->full_name,
            'email' => $data['email'] ?? $contactform->email,
            'message' => $data['message'] ?? $contactform->message,
        ]);

        return $contactform;
    }

    public function deleteContactForm($id): bool
    {
        $contactform = ContactForm::findOrFail($id);
        return $contactform->delete();
    }
}
