<?php

namespace App\Spiders\ItemProcessors;

use App\Models\PropertyListing;
use Illuminate\Support\Facades\Log;
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
