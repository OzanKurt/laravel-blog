<?php

namespace OzanKurt\Blog\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OzanKurt\Blog\Models\Comment;
use OzanKurt\Blog\Models\Post;

trait BlogUser
{
    public function blogPosts(): HasMany
    {
        return $this->hasMany(config('blog.models.post'), 'user_id', $this->getKeyName());
    }

    public function latestBlogPost(): HasOne
    {
        return $this->blogPosts()->one()->latestOfMany();
    }

    public function blogComments(): HasMany
    {
        return $this->hasMany(config('blog.models.comment'), 'user_id', $this->getKeyName());
    }

    public function latestBlogComment(): HasOne
    {
        return $this->blogComments()->one()->latestOfMany();
    }
}
