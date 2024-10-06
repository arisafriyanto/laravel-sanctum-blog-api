<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $categories,
            'message' => 'Get all categories success',
        ], 200);
    }

    public function showPosts(Category $category)
    {
        $posts = $category->posts()->latest()->get()->map(function ($post) {
            $post->published_on = $post->created_at->diffForHumans();
            return $post;
        });

        return response()->json([
            'status' => true,
            'data' => [
                'category' => $category,
                'posts' => $posts
            ],
            'message' => 'Get posts category success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $attr = $request->all();
        $attr['slug'] = Str::slug($request->name);

        $category = Category::create($attr);

        return response()->json([
            'status' => true,
            'data' => $category,
            'message' => 'Create category success',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'status' => true,
            'data' => $category,
            'message' => 'Get category success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $attr = $request->all();

        $category->update($attr);

        return response()->json([
            'status' => true,
            'data' => $category,
            'message' => 'Update category success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return response()->json([
                'status' => false,
                'errors' => 'Cannot delete category that has posts associated with it.',
            ], 400);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'data' => [],
            'message' => 'Delete category success',
        ], 200);
    }
}
