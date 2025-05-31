<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Image;
use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CustomerService
{
    use SaveImage, DeleteImage;

    public function getAllCustomers()
    {
        return Customer::with('image')->get();
    }

    public function findCustomerById($id)
    {
        return Customer::with('image')->findOrFail($id);
    }

    public function storeCustomer(array $data)
    {
        $imageFile = request()->file('image');

        $customer = Customer::create([
            'comment' => $data['comment'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'customer');
            $publicUrl = asset('storage/' . $path);
            $customer->image()->create(['url' => $publicUrl]);
        }

        return $customer->load('image');
    }

    public function updateCustomer($id, array $data)
    {
        $customer = Customer::with('image')->findOrFail($id);

        if (isset($data['comment'])) {
            $customer->comment = $data['comment'];
            $customer->save();
        }

        $imageFile = request()->file('image');

        if ($imageFile instanceof UploadedFile) {
            if ($customer->image) {
                $relativePath = str_replace(asset('storage') . '/', '', $customer->image->url);
                $this->delete($relativePath); 

                $path = $this->upload($imageFile, 'customer');
                $publicUrl = asset('storage/' . $path);
                $customer->image->update(['url' => $publicUrl]);
            } else {
                $path = $this->upload($imageFile, 'customer');
                $publicUrl = asset('storage/' . $path);
                $customer->image()->create(['url' => $publicUrl]);
            }
        }

        return $customer->load('image');
    }

    public function deleteCustomer($id): bool
    {
        $customer = Customer::findOrFail($id);

        if ($customer->image) {
            $relativePath = str_replace(asset('storage') . '/', '', $customer->image->url);
            $this->delete($relativePath); 
            $customer->image->delete();   
        }

        return $customer->delete(); 
    }

}
