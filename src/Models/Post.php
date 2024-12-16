<?php

namespace OzanKurt\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OzanKurt\Blog\Enums\PostType;
use OzanKurt\Blog\Enums\VideoType;
use OzanKurt\Blog\Models\Traits\HasVideo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;
    use HasVideo;

    public function getTable(): string
    {
        return config('blog.database.table_prefix') . 'posts';
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'type_id' => PostType::class,
            'video_type_id' => VideoType::class,
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(config('blog.models.category'), 'category_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('blog.models.user'), 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(config('blog.models.comment'), 'post_id', 'id');
    }

    public function latestComment(): HasOne
    {
        return $this->comments()->one()->latestOfMany();
    }
}
