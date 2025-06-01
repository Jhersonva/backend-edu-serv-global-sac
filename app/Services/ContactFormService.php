<?php

namespace App\Services;

use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use App\Models\ContactForm;
use Illuminate\Http\UploadedFile;
class ContactFormService
{
    use SaveImage, DeleteImage;

    public function getAllContactForm()
    {
        return ContactForm::with('image')->get();
    }

    public function findContactFormById($id)
    {
        return ContactForm::with('image')->findOrFail($id);
    }

    public function storeContactForm(array $data)
    {
        $imageFile = request()->file('image');

        $contactform = ContactForm::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'contactform');
            $publicUrl = asset('storage/' . $path);
            $contactform->image()->create(['url' => $publicUrl]);
        }

        return $contactform->load('image');
    }

    public function updateContactForm($id, array $data)
    {
        $contactform = ContactForm::with('image')->findOrFail($id);

        $contactform->update([
            'full_name' => $data['full_name'] ?? $contactform->full_name,
            'email' => $data['email'] ?? $contactform->email,
            'message' => $data['message'] ?? $contactform->message,
        ]);

        if ($imageFile = request()->file('image')) {
            if ($contactform->image) {
                
                $oldPath = str_replace(asset('storage') . '/', '', $contactform->image->url);
                $this->delete($oldPath);

                
                $path = $this->upload($imageFile, 'contactform');
                $publicUrl = asset('storage/' . $path);

                
                $contactform->image->update(['url' => $publicUrl]);
            } else {
                $path = $this->upload($imageFile, 'contactform');
                $publicUrl = asset('storage/' . $path);
                $contactform->image()->create(['url' => $publicUrl]);
            }
        }

        return $contactform->load('image');
    }

    public function deleteContactForm($id): bool
    {
        $contactform = ContactForm::findOrFail($id);

        if ($contactform->image) {
            $relativePath = str_replace(asset('storage') . '/', '', $contactform->image->url);
            $this->delete($relativePath); 
            $contactform->image->delete();   
        }

        return $contactform->delete(); 
    }
    
}
