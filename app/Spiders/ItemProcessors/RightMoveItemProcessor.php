<?php

namespace App\Spiders\ItemProcessors;

use App\Mail\NewListing;
use App\Models\PropertyListing;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RoachPHP\ItemPipeline\ItemInterface;
use RoachPHP\ItemPipeline\Processors\ItemProcessorInterface;
use RoachPHP\Support\Configurable;

class RightMoveItemProcessor implements ItemProcessorInterface
{
    use Configurable;

    public function processItem(ItemInterface $item): ItemInterface
    {
        $props = $item->all();
        if(count(PropertyListing::where('right_move_id', $props['propertyId'])->get()) < 1){
            Log::info('hello');
            $property = PropertyListing::create([
                'right_move_id' => $props['propertyId'],
                'agent' => $props['agent'],
                'price' => $props['price'],
                'address' => $props['address'],
                'search_term' => $props['search'],
                'uri' => $props['uri'],
            ]);
            $property->save();
            foreach (['knaftoli@gmail.com', 'shaul@cliffsidegroup.co.uk'] as $recipient) {
                Mail::to($recipient)->send(new NewListing($property));
            }
            Log::info('Email Sent');
        }
        return $item;
    }

    private function defaultOptions(): array
    {
        // If not overwritten by the user, the default threshold
        // is 4. Any game with fewer goals than that will get
        // dropped.
        return [

        ];
    }
}
