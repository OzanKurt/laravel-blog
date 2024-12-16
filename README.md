# Laravel Blog

Laravel Blog is a package that provides a simple blog system for Laravel applications.

## Features

- Categories
- Posts
- Comments
- Media Types (Text, Single Image, Multiple Image, Video)
- Video Embedding (YouTube, Vimeo, DailyMotion)

## External Requirements

This package requires 2 external packages for its functionality.

- [spatie/laravel-sluggable](https://github.com/spatie/laravel-sluggable)
- [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary)

## External Suggestions

You can use the following packages to enhance the functionality of the blog system.

- [spatie/laravel-tags](https://github.com/spatie/laravel-tags)

## Installation

You can install the package via composer:

```bash
composer require ozankurt/laravel-blog
```

Publish the package assets:

```bash
php artisan vendor:publish --provider="Ozankurt\Blog\BlogServiceProvider"
```

Run the migrations:

```bash
php artisan migrate
```

## Usage

Modify the `config/blog.php` configuration file to customize the package settings.

```php
return [

    'database' => [
        'connection' = env('DB_CONNECTION', 'mysql'),
        'table_prefix' => 'blog_',
    ],

    'models' => [
        'user' => App\Models\User::class,

        /** If you want to use your own models, you can extend the package models. */
        'category' => OzanKurt\Blog\Category::class,
        'comment' => OzanKurt\Blog\Comment::class,
        'post' => OzanKurt\Blog\Post::class,
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
```

## API

#### Category

| Methods       | Relationship                         |
| ------------- |--------------------------------------|
| posts() | HasMany     |
| latestPost() | HasOne |

#### Post

Posts have a `type_id` attribute so that the users can choose between:
- Text Post
- Single Image Post
- Multiple Image Post
- Video Post

Videos support 3 different providers:

- YouTube
- Vimeo
- DailyMotion

| Methods       | Relationship                        |
| ------------- |-------------------------------------|
| category() | BelongsTo   |
| user() | BelongsTo       |
| comments() | HasMany     |
| latestComment() | HasOne |

#### Comment

| Methods       | Relationship                    |
| ------------- |---------------------------------|
| post() | BelongsTo |
| user() | BelongsTo |
