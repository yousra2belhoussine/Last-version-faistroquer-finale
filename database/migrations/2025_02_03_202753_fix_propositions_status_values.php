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

        // Now modify the column to add 'completed' status
        DB::statement("ALTER TABLE propositions MODIFY COLUMN status ENUM('pending', 'accepted', 'rejected', 'cancelled', 'completed') DEFAULT 'pending'");
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

        // Then revert the column definition
        DB::statement("ALTER TABLE propositions MODIFY COLUMN status ENUM('pending', 'accepted', 'rejected', 'cancelled') DEFAULT 'pending'");
    }
};
