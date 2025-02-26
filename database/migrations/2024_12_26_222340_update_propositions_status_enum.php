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
        Schema::table('propositions', function (Blueprint $table) {
            // Supprimer l'ancienne colonne et la recréer avec la nouvelle contrainte
            $table->dropColumn('status');
            $table->string('status')->default('pending')->after('id');
        });

        // Ajouter la contrainte CHECK pour simuler un ENUM
        DB::statement("CREATE TRIGGER check_proposition_status
            BEFORE INSERT ON propositions
            FOR EACH ROW
            BEGIN
                IF NEW.status NOT IN ('pending', 'accepted', 'rejected', 'cancelled', 'completed') THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Invalid status value';
                END IF;
            END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer le trigger
        DB::statement("DROP TRIGGER IF EXISTS check_proposition_status");

        Schema::table('propositions', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->string('status')->default('pending')->after('id');
        });
    }
};
