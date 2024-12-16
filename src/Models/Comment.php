<?php

namespace OzanKurt\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    public function post(): BelongsTo
    {
        return $this->belongsTo(config('blog.models.post'), 'post_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('blog.models.user'), 'user_id', 'id');
    }
}

