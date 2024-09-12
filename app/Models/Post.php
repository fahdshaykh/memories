<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'image'
    ];

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
