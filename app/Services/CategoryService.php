<?php

namespace App\Services;

use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

class CategoryService
{
    use SaveImage, DeleteImage;

    public function getAllCategories()
    {
        return Category::with('image')->get();
    }

    public function findCategoryById($id)
    {
        return Category::with(['image', 'services.image'])->findOrFail($id);
    }

    public function storeCategory(array $data)
    {
        $imageFile = request()->file('image');

        $category = Category::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'category');
            $category->image()->create(['url' => asset('storage/' . $path)]);
        }

        return $category->load('image');
    }

    public function updateCategory($id, array $data)
    {
        $category = Category::with('image')->findOrFail($id);

        $category->update([
            'name' => $data['name'] ?? $category->name,
            'description' => $data['description'] ?? $category->description,
        ]);

        if ($imageFile = request()->file('image')) {
            $path = $this->upload($imageFile, 'category');
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

    public function deleteCategory($id): bool
    {
        $category = Category::with('image')->findOrFail($id);

        if ($category->image) {
            $this->delete(str_replace(asset('storage') . '/', '', $category->image->url));
            $category->image->delete();
        }

        return $category->delete();
    }

    public function filterCategories(?string $area = null)
    {
        $query = Category::with('image');

        if ($area) {
            $query->where('name', 'like', '%' . $area . '%');
        }

        return $query->get();
    }
}