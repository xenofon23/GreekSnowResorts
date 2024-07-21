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
        Schema::create('bookings_trable', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('snow_resort_id');
            $table->unsignedBigInteger('user_id');
            $table->string('order_time');
        });
        Schema::rename('bookings_trable', 'bookings');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings_trable');
    }
};
