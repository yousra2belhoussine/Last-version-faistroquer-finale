<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Déplacer les données de images vers ad_images si nécessaire
        if (Schema::hasTable('images')) {
            $images = DB::table('images')->get();
            foreach ($images as $image) {
                DB::table('ad_images')->insert([
                    'ad_id' => $image->ad_id,
                    'path' => $image->path,
                    'created_at' => $image->created_at,
                    'updated_at' => $image->updated_at,
                ]);
            }
            
            // Supprimer la table images
            Schema::dropIfExists('images');
        }
    }

    public function down(): void
    {
        // Ne rien faire dans down() car nous ne voulons pas recréer la table
    }
}; 