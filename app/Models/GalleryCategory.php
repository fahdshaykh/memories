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
        'content',
        'image',
        'status',
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }
}
