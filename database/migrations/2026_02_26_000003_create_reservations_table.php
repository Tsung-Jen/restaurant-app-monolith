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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->date('reservation_date');
            $table->enum('session', ['lunch', 'dinner']); // lunch or dinner
            $table->time('reservation_time');
            $table->integer('number_of_guests');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('reservation_date');
            $table->index('session');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
