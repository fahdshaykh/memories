<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

class Post extends Model
{
    use HasFactory;
    use HasTags;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'image',
        'published_at'
    ];
    
    // Optional: customize tag type (useful if you have multiple tag types)
    public static function getTagClassName(): string
    {
        return Tag::class;
    }
    
    // Optional: scope to get published posts
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function scopeLatest(Builder $query)
    {   
        return $query->orderBy(static::CREATED_AT, 'desc'); 
    }
}
