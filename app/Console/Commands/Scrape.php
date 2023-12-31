<?php

namespace App\Console\Commands;

use App\Spiders\RightMoveSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;

class Scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape Right Move';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Roach::startSpider(RightMoveSpider::class);
    }
}
