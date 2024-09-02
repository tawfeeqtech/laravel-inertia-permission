<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Post;
use App\Utils\MediaUpload;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use App\Traits\UploadImageTrait;

class StoringPost
{
    // use UploadImageTrait;
    protected $model;
    function __construct()
    {
        $this->model = new Post();
    }

    function storePost($request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $post = Post::create($data);
        return $post;
    }

    function storeImage($request, $post)
    {

        $image = $request->file('image');
        // $imageName = time() . '.' . $image->getClientOriginalExtension();
        // $image->move(public_path('images/posts'), $imageName);

        // // Save the image details to the database
        // $imageUrl = 'images/posts/' . $imageName;
        // $imageUrl = $this->uploadFile($image, 'posts');
        $imageUrl = MediaUpload::uploadFile($image, 'posts');

        $post->image()->create([
            'url' => $imageUrl,
        ]);

        // return $post;
    }

    function storeCategoryToPost($request, $post)
    {
        foreach ($request->categories as $value) {
            $post->categories()->attach($value['id']);
        }
    }

    function updateCategoryToPost($request, $post)
    {
        $post->categories()->sync($request->input('categories.*.id'));
    }

    function updatePost($request, $post)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $post->update($data);
        return $post;
    }
    function store($request)
    {
        try {
            DB::beginTransaction();
            $post = $this->storePost($request);

            if ($request->has('categories')) {
                $this->storeCategoryToPost($request, $post);
            }

            if ($request->hasFile('image')) {
                $this->storeImage($request, $post);
            }

            DB::commit();
            return to_route('posts.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    function updateImage($post, $imagePath)
    {
        $image = $post->image;
        if ($image) {
            Storage::disk('upload')->delete('posts/' . $image['url']);
            $image->update([
                'url' => $imagePath,
            ]);
        } else {
            $newImage = new Image([
                'url' => $imagePath,
            ]);
            $post->image()->save($newImage);
        }
    }
    function update($request, $post)
    {
        try {
            DB::beginTransaction();
            $post = $this->updatePost($request, $post);

            if ($request->has('categories')) {
                $this->updateCategoryToPost($request, $post);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = MediaUpload::uploadFile($image, 'posts');
                $this->updateImage($post, $imagePath);
            }
            DB::commit();
            return to_route('posts.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
