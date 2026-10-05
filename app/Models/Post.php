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
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'content',
        'image',
        'published_at'
    ];

    /**
     * SEO Title accessor with fallback
     */
    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: ($this->title . ' | Wisherpro');
    }

    /**
     * SEO Description accessor with smart snippet fallback
     */
    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        $raw = strip_tags($this->content ?? '');
        $cleaned = trim(preg_replace('/\s+/', ' ', $raw));
        return $cleaned ? \Illuminate\Support\Str::limit($cleaned, 155) : ($this->title . ' - Read inspiring quotes and memories on Wisherpro.');
    }

    /**
     * SEO Keywords accessor with tags fallback
     */
    public function getSeoKeywordsAttribute(): string
    {
        if ($this->meta_keywords) {
            return $this->meta_keywords;
        }
        if ($this->relationLoaded('tags') || $this->tags()->exists()) {
            $tagNames = $this->tags->pluck('name')->implode(', ');
            if ($tagNames) {
                return $tagNames;
            }
        }
        return 'quotes, memories, life quotes, inspirational, ' . strtolower($this->title);
    }

    /**
     * Estimated reading time in minutes
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        return max(1, (int) ceil($words / 200));
    }

    /**
     * Approximate word count
     */
    public function getWordCountAttribute(): int
    {
        return str_word_count(strip_tags($this->content ?? ''));
    }
    
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
        return $this->belongsTo(PostCategory::class, 'category_id');
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
