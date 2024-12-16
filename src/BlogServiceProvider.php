<?php

namespace OzanKurt\Blog;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        AboutCommand::add('Laravel Blog', fn () => ['Version' => '1.0.0']);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/blog.php', 'blog'
        );

        $this->publishes([
            __DIR__.'/../config/blog.php' => config_path('blog.php'),
        ], 'blog-config');

        $this->publishesMigrations([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'blog-migrations');
    }
}
