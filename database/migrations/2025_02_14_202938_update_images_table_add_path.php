<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            if (!Schema::hasColumn('images', 'path')) {
                $table->string('path')->after('ad_id');
            }
            if (!Schema::hasColumn('images', 'order')) {
                $table->integer('order')->default(0)->after('path');
            }
            if (!Schema::hasColumn('images', 'is_primary')) {
                $table->boolean('is_primary')->default(false)->after('order');
            }
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn(['path', 'order', 'is_primary']);
        });
    }
};
