<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;

class CategoryService
{
    use SaveImage, DeleteImage;

    public function getAllCategory()
    {
        return Category::with(['image', 'serviceCategories'])->get();
    }

    public function findByIdCategory($id)
    {
        return Category::with(['image', 'serviceCategories'])->findOrFail($id);
    }

    public function storeCategory(array $data)
    {
       $category = Category::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        $category->serviceCategories()->sync($data['service_category_ids']);

        if ($image = request()->file('image')) {
            $path = $this->upload($image, 'categories');
            $category->image()->create(['url' => asset('storage/' . $path)]);
        }

        return $category->load('image', 'serviceCategories');
    }

    public function updateCategory($id, array $data)
    {
        $category = Category::with('image')->findOrFail($id);

        $category->update([
            'name' => $data['name'] ?? $category->name,
            'description' => $data['description'] ?? $category->description,
        ]);

        if (isset($data['service_category_ids'])) {
            $category->serviceCategories()->sync($data['service_category_ids']);
        }

        if ($image = request()->file('image')) {
            $path = $this->upload($image, 'categories');
            $url = asset('storage/' . $path);

            if ($category->image) {
                $this->delete(str_replace(asset('storage') . '/', '', $category->image->url));
                $category->image->update(['url' => $url]);
            } else {
                $category->image()->create(['url' => $url]);
            }
        }

        return $category->load('image');
    }

    public function deleteCategory($id)
    {
        $category = Category::with('image')->findOrFail($id);

        if ($category->image) {
            $this->delete(str_replace(asset('storage') . '/', '', $category->image->url));
            $category->image->delete();
        }

        return $category->delete();
    }
}
