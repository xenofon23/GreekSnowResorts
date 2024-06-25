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
        Schema::create('_slopes_', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('snow_resort_id');
            $table->string('name');
            $table->string('difficulty');
            $table->integer('length_m');
            $table->integer('altitude_m');
            $table->decimal('average_slope_percent',5,2);
            $table->string('details');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_slopes_');
    }
};
