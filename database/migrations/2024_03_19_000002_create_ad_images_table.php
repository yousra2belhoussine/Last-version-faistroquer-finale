<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('ad_images')) {
            Schema::create('ad_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ad_id')->constrained('ads')->onDelete('cascade');
                $table->string('image_path');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('ad_images');
    }
}; 