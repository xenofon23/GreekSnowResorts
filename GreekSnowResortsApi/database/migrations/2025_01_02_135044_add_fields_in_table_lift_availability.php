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
        Schema::table('lift_availability', function (Blueprint $table) {
            $table->integer('occupancy')->nullable();
            $table->bigInteger('duration')->nullable();
            $table->bigInteger('capacity')->nullable();
            $table->json('coordinates')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lift_availability', function (Blueprint $table) {
            $table->dropColumn('occupancy');
            $table->dropColumn('duration');
            $table->dropColumn('capacity');
            $table->dropColumn('coordinates');
        });
    }
};
