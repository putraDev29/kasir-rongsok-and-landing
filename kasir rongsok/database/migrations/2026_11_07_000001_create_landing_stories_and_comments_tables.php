<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing_stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('tag')->nullable()->default('Cerita Depo');
            $table->string('image_path');
            $table->text('caption')->nullable();
            $table->unsignedInteger('likes_count')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('landing_story_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained('landing_stories')->cascadeOnDelete();
            $table->string('user_name');
            $table->text('comment'); // Translated / processed Indonesian text
            $table->text('original_comment')->nullable(); // Original visitor comment
            $table->string('detected_language', 20)->nullable()->default('id');
            $table->boolean('is_translated')->default(false);
            $table->unsignedInteger('likes_count')->default(0);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_story_comments');
        Schema::dropIfExists('landing_stories');
    }
};

