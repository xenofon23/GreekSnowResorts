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
        Schema::create('lift_availability', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('snow_resort_id');
            $table->string('name');
            $table->boolean('is_open'); // Ανοιχτός ή κλειστός
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lift_availability');
    }
};
