<?php

namespace App\Services;

use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use App\Models\Blog;
use Illuminate\Http\UploadedFile;
class BlogService
{
    use SaveImage, DeleteImage;

    public function getAllBlog()
    {
        return Blog::with('image')->get();
    }

    public function findBlogById($id)
    {
        return Blog::with('image')->findOrFail($id);
    }

    public function storeBlog(array $data)
    {
        $imageFile = request()->file('image');

        $blog = Blog::create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'blog');
            $publicUrl = asset('storage/' . $path);
            $blog->image()->create(['url' => $publicUrl]);
        }

        return $blog->load('image');
    }

    public function updateBlog($id, array $data)
    {
        $blog = Blog::with('image')->findOrFail($id);

        $blog->update([
            'title' => $data['title'] ?? $blog->title,
            'description' => $data['description'] ?? $blog->description,
        ]);

        if ($imageFile = request()->file('image')) {
            if ($blog->image) {
                
                $oldPath = str_replace(asset('storage') . '/', '', $blog->image->url);
                $this->delete($oldPath);

                
                $path = $this->upload($imageFile, 'blog');
                $publicUrl = asset('storage/' . $path);

                
                $blog->image->update(['url' => $publicUrl]);
            } else {
                $path = $this->upload($imageFile, 'blog');
                $publicUrl = asset('storage/' . $path);
                $blog->image()->create(['url' => $publicUrl]);
            }
        }

        return $blog->load('image');
    }

    public function deleteBlog($id): bool
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            $relativePath = str_replace(asset('storage') . '/', '', $blog->image->url);
            $this->delete($relativePath); 
            $blog->image->delete();   
        }

        return $blog->delete(); 
    }
    
}
