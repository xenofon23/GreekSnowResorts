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
            $table->dropColumn('name');
            $table->string('site')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('snow_resorts', function (Blueprint $table) {
            $table->string('name');
            $table->string('site')->nullable(false)->change();
        });
    }
};
