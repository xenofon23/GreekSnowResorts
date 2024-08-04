<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteOldRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $tenMinutesAgo = Carbon::now()->subMinutes(10);
        DB::table('lift_availability')
            ->where('created_at', '<', $tenMinutesAgo)
            ->delete();

        $this->info('Old records deleted successfully.');
    }
}
