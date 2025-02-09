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
        // Add profile_photo_path to users if it doesn't exist
        if (!Schema::hasColumn('users', 'profile_photo_path')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_photo_path')->nullable()->after('email');
            });
        }

        // Add condition column to ads if it doesn't exist
        if (!Schema::hasColumn('ads', 'condition')) {
            Schema::table('ads', function (Blueprint $table) {
                $table->string('condition')->nullable();
            });
        }

        // Create feedback table if it doesn't exist
        if (!Schema::hasTable('feedback')) {
            Schema::create('feedback', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('type');
                $table->text('content');
                $table->boolean('is_resolved')->default(false);
                $table->timestamps();
            });
        }

        // Create password reset tokens table if it doesn't exist
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        // Add is_published to articles if it doesn't exist
        if (!Schema::hasColumn('articles', 'is_published')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->boolean('is_published')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove profile_photo_path from users if it exists
        if (Schema::hasColumn('users', 'profile_photo_path')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('profile_photo_path');
            });
        }

        // Remove condition from ads if it exists
        if (Schema::hasColumn('ads', 'condition')) {
            Schema::table('ads', function (Blueprint $table) {
                $table->dropColumn('condition');
            });
        }

        // Drop feedback table if it exists
        Schema::dropIfExists('feedback');

        // Drop password reset tokens table if it exists
        Schema::dropIfExists('password_reset_tokens');

        // Remove is_published from articles if it exists
        if (Schema::hasColumn('articles', 'is_published')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('is_published');
            });
        }
    }
};
