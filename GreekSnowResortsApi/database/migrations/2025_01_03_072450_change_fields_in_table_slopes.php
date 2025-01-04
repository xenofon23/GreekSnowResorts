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
        Schema::table('slopes', function (Blueprint $table) {
            $table->bigInteger('length_m')->nullable()->change();
            $table->bigInteger('altitude_m')->nullable()->change();
            $table->integer('average_slope_percent')->nullable()->change();
            $table->string('details')->nullable()->change();
            $table->foreign('snow_resort_id')->references('id')->on('snow_resorts')->onDelete('cascade');
            $table->string('difficulty')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slopes', function (Blueprint $table) {
            //
        });
    }
};
