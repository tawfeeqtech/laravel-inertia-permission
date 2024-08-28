<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {

        return Inertia::render('Admin/Posts/PostIndex', [
            'posts' => PostResource::collection(Post::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Posts/PostCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request): RedirectResponse
    {
        Post::create($request->validated());
        return to_route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): Response
    {
        return Inertia::render('Admin/Posts/PostEdit', [
            'post' => new PostResource($post)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return back();
    }
}
