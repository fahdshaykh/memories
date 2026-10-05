<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $table = 'post_categories';

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'content',
        'image',
        'status',
    ];

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: ($this->title . ' Quotes & Stories | Wisherpro');
    }

    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        $raw = strip_tags($this->content ?? '');
        $cleaned = trim(preg_replace('/\s+/', ' ', $raw));
        return $cleaned ? \Illuminate\Support\Str::limit($cleaned, 155) : ('Explore the best ' . $this->title . ' quotes, memories, and stories on Wisherpro.');
    }

    public function getSeoKeywordsAttribute(): string
    {
        return $this->meta_keywords ?: (strtolower($this->title) . ', quotes, memories, sayings, inspiration');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
