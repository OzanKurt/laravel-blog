<?php

namespace OzanKurt\Blog\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return config('blog.database.table_prefix') . 'categories';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(config('blog.models.post'), 'category_id', 'id');
    }

    public function latestPost(): HasOne
    {
        return $this->posts()->one()->latestOfMany();
    }
}
