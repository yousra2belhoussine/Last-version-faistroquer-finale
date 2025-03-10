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
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->string('offer'); // Assurez-vous que cette colonne existe
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled', 'completed'])->default('pending');
            $table->text('message')->nullable();
            $table->string('meeting_location')->nullable(); // Assurez-vous que cette colonne existe
            $table->dateTime('meeting_date')->nullable();
            $table->boolean('online_exchange')->default(false);
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propositions');
    }
}; 