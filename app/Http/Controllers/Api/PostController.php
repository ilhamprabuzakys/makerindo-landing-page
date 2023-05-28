<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Jobs\PostJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function indexredis()
    {
        // $posts = User::orderBy('updated_at', 'desc')->get();
        // $job = new PostJob();
        // $this->dispatch($job);

        $posts = Cache::remember('posts', 10 * 60, function () {
            return Post::orderBy('updated_at', 'desc')->get();
        });

        return response()->json([
            'data' => PostResource::collection($posts),
            'message' => 'Fetch all Posts Data',
            'success' => true
        ]);
    }

    public function index()
    {
        $posts = Post::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'data' => PostResource::collection($posts),
            'message' => 'Fetch all Markers Data',
            'success' => true
        ]);
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        $post = Post::create($validatedData);

        return response()->json([
            'data' => new PostResource($post),
            'message' => "Postingan dengan judul: $post->title berhasil ditambahkan.",
            'success' => true
        ]);
    }

    public function show(Post $post)
    {
        if ($post) {
            return response()->json([
                'data' => new PostResource($post),
                'message' => "Data postingan dengan id $post->id berhasil ditemukan.",
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Data tidak ditemukan.',
                'success' => false
            ], 404);
        }
    }

    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required',
            'slug' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors());
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json([
                'data' => $validator->fails(),
                'message' => "Something went wrong",
                'success' => \false
            ], 500);
        }

        $validatedData = $validator->validated();

        $post->update($validatedData);

        return response()->json([
            'data' => new PostResource($post),
            'message' => "Postingan $post->title berhasil diupdate.",
            'success' => true
        ]);
    }

    public function destroy(Post $post)
    {
        $oldTitle = $post->title;
        $post->delete();

        // return response()->json(null, 204);
        return response()->json([
            'data' => [],
            'message' => "Post dengan judul: $oldTitle telah dihapus.",
            'success' => true
        ]);
    }
}
