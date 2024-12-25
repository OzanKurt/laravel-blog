<?php

return [

    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'table_prefix' => 'blog_',
    ],

    'models' => [
        'user' => App\Models\User::class,

        /** If you want to use your own models, you can extend the package models. */
        'category' => OzanKurt\Blog\Models\Category::class,
        'comment' => OzanKurt\Blog\Models\Comment::class,
        'post' => OzanKurt\Blog\Models\Post::class,
    ],

    'media' => [
        'disk' => 'public',
    ],

    'video_thumbnail_qualities' => [
        /** Vimeo options: 'thumbnail_small', 'thumbnail_medium', 'thumbnail_large' */
        'vimeo' => 'thumbnail_medium',
        /** YouTube options: '0', '1', '2', '3', 'default', 'hqdefault', 'mqdefault', 'sddefault', 'maxresdefault' */
        'youtube' => 'default',
    ],

    'caching' => [
        'enabled' => false,
        'duration' => 15,
    ],
];
