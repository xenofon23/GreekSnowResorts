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
        Schema::table('snow_reports', function (Blueprint $table) {
            $table->string('last_snowfall')->nullable()->change();
            $table->integer('depth_middle')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snow_reports', function (Blueprint $table) {
            $table->date('last_snowfall')->change();
            $table->dropColumn('depth_middle');
        });
    }
};
