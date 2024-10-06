<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')->latest()->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'category' => [
                    'id' => $post->category->id,
                    'name' => $post->category->name,
                    'slug' => $post->category->slug,
                ],
                'title' => $post->title,
                'slug' => $post->slug,
                'body' => $post->body,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'published_on' => $post->created_at->diffForHumans(),
                'image_url' => $post->getFirstMediaUrl('images'),
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $posts,
            'message' => 'Get all posts success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $attr = $request->all();

        Category::whereId($attr['category_id'])->firstOrFail();

        $attr['slug'] = Str::slug($request->title);

        $post = Post::create($attr);

        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')
                ->usingName($post->title)
                ->toMediaCollection('images');
        }

        return response()->json([
            'status' => true,
            'data' => $post,
            'message' => 'Create post success',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $formattedPost = [
            'id' => $post->id,
            'category' => [
                'id' => $post->category->id,
                'name' => $post->category->name,
                'slug' => $post->category->slug,
            ],
            'title' => $post->title,
            'slug' => $post->slug,
            'body' => $post->body,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'published_on' => $post->created_at->diffForHumans(),
            'image_url' => $post->getFirstMediaUrl('images'),
            'media' => $post->media->map(function ($media) {
                return [
                    'id' => $media->id,
                    'model_type' => $media->model_type,
                    'model_id' => $media->model_id,
                    'uuid' => $media->uuid,
                    'collection_name' => $media->collection_name,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'disk' => $media->disk,
                    'conversions_disk' => $media->conversions_disk,
                    'size' => $media->size,
                    'manipulations' => $media->manipulations,
                    'custom_properties' => $media->custom_properties,
                    'generated_conversions' => $media->generated_conversions,
                    'responsive_images' => $media->responsive_images,
                    'order_column' => $media->order_column,
                    'created_at' => $media->created_at,
                    'updated_at' => $media->updated_at,
                    'original_url' => $media->getUrl(),
                    'preview_url' => $media->getUrl('preview'),
                ];
            })->toArray(),
        ];

        return response()->json([
            'status' => true,
            'data' => $formattedPost,
            'message' => 'Get post success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $attr = $request->all();
        // * Slug tidak diupdate karena berhubungan dengan SEO

        Category::whereId($attr['category_id'])->firstOrFail();

        $post->update($attr);

        if ($request->hasFile('image')) {
            $post->clearMediaCollection('images');
            $post->addMediaFromRequest('image')
                ->usingName($post->title)
                ->toMediaCollection('images');
        }

        return response()->json([
            'status' => true,
            'data' => $post,
            'message' => 'Update post success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        $post->clearMediaCollection('images');

        return response()->json([
            'status' => true,
            'data' => [],
            'message' => 'Delete post success',
        ], 200);
    }
}
