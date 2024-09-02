<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Services\StoringPost;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        // $posts = Post::all();
        // $posts->load('author');

        $posts = Post::with('author')->get();


        return Inertia::render('Admin/Posts/PostIndex', [
            'posts' => PostResource::collection($posts)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', Post::class);
        return Inertia::render('Admin/Posts/PostCreate', [
            'categories' => CategoryResource::collection(Category::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        return (new StoringPost())->store($request);
    }


    /* public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $path = $request->file('file')->store('public/images/posts');

        return response()->json(['url' => $path], 200);
    } */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): Response
    {
        $this->authorize('update', $post);

        $post->load('categories');

        return Inertia::render('Admin/Posts/PostEdit', [
            'post' => new PostResource($post),
            'categories' => CategoryResource::collection(Category::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        return (new StoringPost())->update($request, $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $image = $post->image;
        if ($image) {
            Storage::disk('upload')->delete('posts/' . $image['url']);
        }

        $post->image()->delete();
        // $post->categories()->detach();

        $post->delete();
        return back();
    }
}
