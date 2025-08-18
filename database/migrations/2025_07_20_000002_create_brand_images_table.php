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
        Schema::create('brand_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->string('original_name');
            $table->string('filename'); // UUID-based filename
            $table->string('path'); // Storage path in Supabase
            $table->string('url'); // Full URL from Supabase
            $table->string('alt_text')->nullable();
            $table->enum('type', ['logo', 'banner', 'thumbnail'])->default('logo');
            $table->string('mime_type');
            $table->bigInteger('size'); // File size in bytes
            $table->json('metadata')->nullable(); // Image dimensions, etc.
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->index(['brand_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_images');
    }
};
