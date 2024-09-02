<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'published_at' => $this->published_at,
            'featured' => $this->featured ? true : false,
            'thumbnail_url' => $this->getThumbnailUrl(), // Add the thumbnail URL here
            'author' => new UserResource($this->whenLoaded('author')), // Include author relationship
            'categories' => $this->whenLoaded('categories'), // Include author relationship
        ];
    }
}
