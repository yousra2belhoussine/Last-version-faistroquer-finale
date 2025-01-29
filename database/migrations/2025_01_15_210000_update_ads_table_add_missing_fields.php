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
        Schema::table('ads', function (Blueprint $table) {
            // Ajout des nouveaux champs
            $table->decimal('price', 10, 2)->nullable();
            $table->string('department')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('exchange_with')->nullable();
            $table->boolean('online_exchange')->default(false);
            $table->enum('condition', ['new', 'like_new', 'good', 'fair'])->nullable();
            
            // Modification du type enum pour correspondre au contrôleur
            $table->dropColumn('type');
            $table->enum('type', ['goods', 'services'])->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn([
                'price',
                'department',
                'city',
                'postal_code',
                'exchange_with',
                'online_exchange',
                'condition'
            ]);
            
            // Restaurer l'ancien type
            $table->dropColumn('type');
            $table->enum('type', ['good', 'service'])->after('description');
        });
    }
};
