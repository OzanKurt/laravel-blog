<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tablePrefix = config('blog.database.table_prefix');

        Schema::create($tablePrefix.'categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create($tablePrefix.'posts', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('category_id')->nullable()->index();
            $table->tinyInteger('type_id')->index();
            $table->tinyInteger('video_type_id')->nullable()->index();
            $table->string('title');
            $table->string('slug')->index();
            $table->text('content')->fulltext();
            $table->integer('view_count')->unsigned();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create($tablePrefix.'comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('post_id')->nullable()->index();
            $table->text('content')->fulltext();
            $table->boolean('is_approved')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        $tablePrefix = config('blog.database.table_prefix');

        Schema::drop($tablePrefix.'categories');
        Schema::drop($tablePrefix.'posts');
        Schema::drop($tablePrefix.'comments');
    }
};
