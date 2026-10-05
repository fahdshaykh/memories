<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;

    protected $table = 'video_categories';

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
        return $this->meta_title ?: ($this->title . ' Videos & Cinematic Clips | Wisherpro');
    }

    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        $raw = strip_tags($this->content ?? '');
        $cleaned = trim(preg_replace('/\s+/', ' ', $raw));
        return $cleaned ? \Illuminate\Support\Str::limit($cleaned, 155) : ('Watch all video stories, quotes, and cinematic clips for ' . $this->title . ' on Wisherpro.');
    }

    public function getSeoKeywordsAttribute(): string
    {
        return $this->meta_keywords ?: (strtolower($this->title) . ', videos, clips, reels, status, video quotes');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'category_id');
    }
}
