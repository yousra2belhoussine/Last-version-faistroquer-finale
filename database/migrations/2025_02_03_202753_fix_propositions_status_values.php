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
        // First, update any invalid status values to 'pending'
        DB::table('propositions')
            ->whereNotIn('status', ['pending', 'accepted', 'rejected', 'cancelled'])
            ->update(['status' => 'pending']);

        // Drop the existing trigger
        DB::statement("DROP TRIGGER IF EXISTS check_proposition_status");

        // Create new trigger with updated status values
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
        // First, update any 'completed' status to 'accepted'
        DB::table('propositions')
            ->where('status', 'completed')
            ->update(['status' => 'accepted']);

        // Drop the existing trigger
        DB::statement("DROP TRIGGER IF EXISTS check_proposition_status");

        // Create trigger with original status values
        DB::statement("CREATE TRIGGER check_proposition_status
            BEFORE INSERT ON propositions
            FOR EACH ROW
            BEGIN
                IF NEW.status NOT IN ('pending', 'accepted', 'rejected', 'cancelled') THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Invalid status value';
                END IF;
            END;");
    }
};
