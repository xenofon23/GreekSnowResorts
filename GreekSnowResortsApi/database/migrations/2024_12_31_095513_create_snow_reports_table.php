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
        Schema::create('snow_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('snow_resort_id');
            $table->date('last_snowfall')->nullable();
            $table->integer('depth_base')->nullable();
            $table->integer('depth_top' )->nullable();
            $table->string('snow_quality')->nullable();
            $table->timestamps();
            $table->foreign('snow_resort_id')->references('id')->on('snow_resorts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('snow_reports');
    }
};
