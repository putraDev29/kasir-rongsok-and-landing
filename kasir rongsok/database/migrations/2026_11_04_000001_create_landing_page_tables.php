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
        // 1. Landing Services
        Schema::create('landing_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->default('Recycle');
            $table->text('short_description');
            $table->text('full_description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Landing Galleries
        Schema::create('landing_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Gudang');
            $table->string('image_path');
            $table->text('caption')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Landing Testimonials
        Schema::create('landing_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_role')->default('Mitra Pengepul');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('avatar_url')->nullable();
            $table->text('content');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Landing FAQs
        Schema::create('landing_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->string('category')->nullable()->default('Umum');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Landing Statistics
        Schema::create('landing_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value'); // e.g. "12", "5000+", "150+"
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->string('icon')->nullable()->default('TrendingUp');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Landing Inquiries (Customer Contact / Penjemputan)
        Schema::create('landing_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('material_type')->nullable();
            $table->string('estimated_weight')->nullable();
            $table->text('address')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // new, contacted, completed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_inquiries');
        Schema::dropIfExists('landing_statistics');
        Schema::dropIfExists('landing_faqs');
        Schema::dropIfExists('landing_testimonials');
        Schema::dropIfExists('landing_galleries');
        Schema::dropIfExists('landing_services');
    }
};

