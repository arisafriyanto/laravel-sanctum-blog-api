<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('post')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'status' => true,
            'data' => $bookmarks,
            'message' => 'Get bookmarks success',
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('post_id'), [
            'post_id' => ['required', 'integer', 'exists:posts,id'],

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $existingBookmark = Bookmark::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->first();

        if ($existingBookmark) {
            return response()->json([
                'status' => false,
                'errors' => 'You have already bookmarked this post',
            ], 409);
        }

        $bookmark = Bookmark::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        return response()->json([
            'status' => true,
            'data' => $bookmark,
            'message' => 'Post bookmarked success',
        ], 201);
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('post_id', $id)
            ->firstOrFail();

        $bookmark->delete();

        return response()->json([
            'status' => true,
            'message' => 'Bookmark deleted success',
        ], 200);
    }
}
