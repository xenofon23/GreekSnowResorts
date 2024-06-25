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
        Schema::rename('_slopes_', 'slopes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
