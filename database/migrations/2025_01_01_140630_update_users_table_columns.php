<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'type')) {
                $table->enum('type', ['particular', 'professional'])->default('particular');
            }
            if (!Schema::hasColumn('users', 'is_validated')) {
                $table->boolean('is_validated')->default(false);
            }
        });

        // Mettre à jour les utilisateurs existants
        DB::table('users')->where('type', 'particular')->update(['is_validated' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['type', 'is_validated']);
        });
    }
};
