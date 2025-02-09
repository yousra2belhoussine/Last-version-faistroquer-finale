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
        if (!Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ad_id')->constrained()->onDelete('cascade');
                $table->string('image_path');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->integer('order')->default(0);
                $table->boolean('is_primary')->default(false);
                $table->timestamps();
                
                // Index pour optimiser les requêtes
                $table->index('ad_id');
                $table->index('is_primary');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
