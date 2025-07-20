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
        Schema::table('avatars', function (Blueprint $table) {
            $table->string('original_name')->nullable()->after('avatar_url');
            $table->string('filename')->nullable()->after('original_name');
            $table->string('path')->nullable()->after('filename');
            $table->string('mime_type')->nullable()->after('path');
            $table->bigInteger('size')->nullable()->after('mime_type');
            $table->json('metadata')->nullable()->after('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('avatars', function (Blueprint $table) {
            $table->dropColumn(['original_name', 'filename', 'path', 'mime_type', 'size', 'metadata']);
        });
    }
};
