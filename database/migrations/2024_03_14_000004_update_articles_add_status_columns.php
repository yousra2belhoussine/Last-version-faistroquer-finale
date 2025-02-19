<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('articles', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
            if (!Schema::hasColumn('articles', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable();
            }
        });

        // Mettre à jour les articles existants pour avoir un statut par défaut
        DB::table('articles')->whereNull('status')->update(['status' => 'pending']);
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_at', 'rejected_at']);
        });
    }
}; 