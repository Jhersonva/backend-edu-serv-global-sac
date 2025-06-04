<?php

namespace App\Services;

use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use App\Models\SubCategory;
use Illuminate\Http\UploadedFile;

class SubCategoryService
{
    use SaveImage, DeleteImage;

    public function getAllSubCategories()
    {
        return SubCategory::with('image')->get();
    }

    public function findSubCategoryById($id)
    {
        return SubCategory::with('image')->find($id);
    }

    public function storeSubCategory(array $data)
    {

         $data['benefits'] = is_array($data['benefits']) ? $data['benefits'] : json_decode($data['benefits'], true);

        $imageFile = request()->file('image');

        $subCategory = SubCategory::create([
            'description' => $data['description'],
            'benefits' => $data['benefits'],
            'category_id' => $data['category_id'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'sub-category');
            $subCategory->image()->create(['url' => asset('storage/' . $path)]);
        }

        return $subCategory->load('image');
    }

    public function updateSubCategory($id, array $data)
    {
        $subCategory = SubCategory::with('image')->findOrFail($id);

        if (isset($data['benefits'])) {
            $data['benefits'] = is_array($data['benefits']) ? $data['benefits'] : json_decode($data['benefits'], true);
        }

        $subCategory->update([
            'description' => $data['description'] ?? $subCategory->description,
            'benefits' => $data['benefits'] ?? $subCategory->benefits,
            'category_id' => $data['category_id'] ?? $subCategory->category_id,
        ]);

        if ($imageFile = request()->file('image')) {
            $path = $this->upload($imageFile, 'sub-category');
            $url = asset('storage/' . $path);

            if ($subCategory->image) {
                $this->delete(str_replace(asset('storage') . '/', '', $subCategory->image->url));
                $subCategory->image->update(['url' => $url]);
            } else {
                $subCategory->image()->create(['url' => $url]);
            }
        }

        return $subCategory->load('image');
    }

    public function deleteSubCategory($id): bool
    {
        $subCategory = SubCategory::with('image')->findOrFail($id);

        if ($subCategory->image) {
            $this->delete(str_replace(asset('storage') . '/', '', $subCategory->image->url));
            $subCategory->image->delete();
        }

        return $subCategory->delete();
    }
}
