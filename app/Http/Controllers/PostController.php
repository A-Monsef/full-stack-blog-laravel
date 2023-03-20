<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    private $isApi;
    public function __construct(Request $request)
    {
        $this->isApi = $request->segment(1) == "api" ? true : false;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->input('category_id');
        $post->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $post->image = basename($path);
        }

        $post->save();

        return response()->json(['message' => 'Post created successfully', 'post' => $post]);
    }
}
