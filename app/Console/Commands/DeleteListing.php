<?php

namespace App\Console\Commands;

use App\Models\PropertyListing;
use Illuminate\Console\Command;

class DeleteListing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-listing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete non relevant listings after 48 hours and relevant listings after 14 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        PropertyListing::where('relevant', 0)
            ->where('created_at', '<', now()->subHours(48))
            ->delete();
    }
}
