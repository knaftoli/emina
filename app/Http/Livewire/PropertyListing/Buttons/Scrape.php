<?php

namespace App\Http\Livewire\PropertyListing\Buttons;

use App\Models\PropertyListing;
use App\Spiders\RightMoveSpider;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use RoachPHP\Roach;

class Scrape extends Component
{
    function scrape() {
        set_time_limit(300);
        Roach::startSpider(RightMoveSpider::class);
    }

    public function render()
    {
        return view('livewire.property-listing.buttons.scrape');
    }
}
