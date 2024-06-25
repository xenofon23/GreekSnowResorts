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
        Schema::table('snow_resorts', function (Blueprint $table) {
            $table->string("name_en",255)->nullable();
            $table->string("name_el",255)->nullable();
            $table->string("location",255)->nullable();
            $table->integer("elevation_base")->nullable();
            $table->integer("elevation_peak")->nullable();
            $table->string("slopes_map",255)->nullable();
            $table->string("site",255)->nullable();





        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snow_resorts', function (Blueprint $table) {
            //
        });
    }
};
