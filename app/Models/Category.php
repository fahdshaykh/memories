<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'slug',
        'content',
        'image',
        'status'
    ];

    public function scopeForPosts($query)
    {
        return $query->where('type', 'post');
    }

    public function scopeForGalleries($query)
    {
        return $query->where('type', 'gallery');
    }

    public function scopeForVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
