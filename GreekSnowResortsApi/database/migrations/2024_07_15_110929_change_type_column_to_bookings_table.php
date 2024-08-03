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
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                // Change the type of the renamed column
                $table->time('order_time')->change();
            });
        } else {
            // Handle the case where the table does not exist
            // You might want to throw an exception or log this
            throw new Exception('Table bookings does not exist');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('bookings')) {
            Schema::rename('bookings', 'bookings_trable');
        } else {
            // Handle the case where the table does not exist
            // You might want to throw an exception or log this
            throw new Exception('Table bookings does not exist');
        }
    }
};
//
