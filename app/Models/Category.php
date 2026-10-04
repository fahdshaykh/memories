<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status'
    ];

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
