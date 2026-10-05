<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $table = 'gallery_categories';

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
        return $this->meta_title ?: ($this->title . ' Photo Gallery Collections | Wisherpro');
    }

    public function getSeoDescriptionAttribute(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        $raw = strip_tags($this->content ?? '');
        $cleaned = trim(preg_replace('/\s+/', ' ', $raw));
        return $cleaned ? \Illuminate\Support\Str::limit($cleaned, 155) : ('Browse high-resolution photo memories and image galleries for ' . $this->title . ' on Wisherpro.');
    }

    public function getSeoKeywordsAttribute(): string
    {
        return $this->meta_keywords ?: (strtolower($this->title) . ', photo gallery, images, wallpapers, photography');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }
}
