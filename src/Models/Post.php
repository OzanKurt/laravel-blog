<?php

namespace OzanKurt\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OzanKurt\Blog\Enums\PostType;
use OzanKurt\Blog\Enums\VideoType;
use OzanKurt\Blog\Models\Traits\HasVideo;
use Spatie\Image\Enums\Constraint;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasSlug;
    use HasVideo;
    use InteractsWithMedia;

    protected $guarded = ['id'];

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

    public function getIdentifier(): string
    {
        return $this->id . '-' . $this->slug;
    }

    public function category(): BelongsTo
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

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $width = data_get($media, 'custom_properties.dimensions.width');
        $height = data_get($media, 'custom_properties.dimensions.height');

        try {
            // if the images width/height is wider than 16/9
            if ($width / $height < 16 / 9) {
                // resize to 320x180 and crop the image to 16/9 from center
                $newHeight = 320 / ($width / $height);
                $this->addMediaConversion('thumb')
                    ->resize(320, $newHeight, [
                        Constraint::PreserveAspectRatio,
                        Constraint::DoNotUpsize,
                    ])
                    ->crop(320, 180, CropPosition::Center)
                    ->performOnCollections('image')
                    ->nonQueued();
            } else {
//                dd($media?->custom_properties['background']);
                $this->addMediaConversion('thumb')
                    ->fit(Fit::Fill, 320, 180, false, $media?->custom_properties['background'])
                    ->performOnCollections('image')
                    ->nonQueued();
            }
        } catch (\Throwable $e) {
            dd($media, $media->custom_properties, $media->custom_properties['dimensions'], $media->custom_properties['dimensions']['height']);
        }
    }
}
