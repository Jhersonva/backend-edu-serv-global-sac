<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Services\BlogService;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    protected BlogService $blogService;

    // Inyectamos el servicio de BlogService en el constructor
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Obtener todos los blogs.
     */
    public function index(): JsonResponse
    {
        $blogs = $this->blogService->getAllBlog();
        return response()->json($blogs);
    }

    /**
     * Obtener un blog por ID.
     */
    public function show($id): JsonResponse
    {
        $blog = $this->blogService->findBlogById($id);
        return response()->json($blog);
    }

    /**
     * Crear un nuevo blog.
     */
    public function store(StoreBlogRequest $request): JsonResponse
    {
        $data = $request->validated();  
        $blog = $this->blogService->storeBlog($data);

        return response()->json($blog, 201); 
    }

    /**
     * Actualizar un blog existente.
     */
    public function update(UpdateBlogRequest $request, $id): JsonResponse
    {
        $data = $request->validated();  
        $blog = $this->blogService->updateBlog($id, $data);

        return response()->json($blog);
    }

    /**
     * Eliminar un blog.
     */
    public function destroy($id): JsonResponse
    {
        $success = $this->blogService->deleteBlog($id);

        if ($success) {
            return response()->json(['message' => 'Blog eliminado exitosamente']);
        } else {
            return response()->json(['message' => 'Blog no encontrado'], 404);
        }
    }
}
