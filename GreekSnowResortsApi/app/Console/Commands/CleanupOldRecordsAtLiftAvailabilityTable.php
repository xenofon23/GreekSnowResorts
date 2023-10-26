<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupOldRecordsAtLiftAvailabilityTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-old-records-at-lift-availability-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = now()->subMinutes(20);

        // Adjust this query to match your table and timestamp column name
        DB::table('lift_availability')
            ->where('created_at', '<', $threshold)
            ->delete();

        $this->info('Records older than 20 minutes have been deleted.');
    }
}
