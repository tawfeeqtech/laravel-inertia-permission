<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->categories()->detach();
        });
    }

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'body',
        'published_at',
        'featured',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'published_at' => 'datetime',
    // ];

    protected $dates = ['published_at'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }
    /**
     * Get the post's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeWithCategory($query, string $category)
    {
        $query->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }

    public function scopeFeatured($query)
    {
        $query->where('featured', true);
    }

    public function scopePopular($query)
    {
        $query->withCount('likes')->orderBy("likes_count", 'desc');
    }

    public function scopeSearch($query, string $search = '')
    {
        $query->where('title', 'like', "%{$search}%");
    }

    public function getThumbnailUrl()
    {
        // $isUrl = str_contains($this->image, 'http');

        if ($this->image) {
            $isUrl = str_contains($this->image->url, 'http');
            // Return the URL directly if it's already an absolute URL
            // return $isUrl ? $this->image->url : Storage::disk('public')->url($this->image->url);
            return $isUrl ? $this->image->url : asset('uploads/posts/' . $this->image->url);
        }

        return asset('images/posts/default-image.jpg');
        // return ($isUrl) ? $this->image : Storage::disk('post_images')->url($this->image);
    }
}
