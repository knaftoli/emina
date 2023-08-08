<?php

namespace App\Spiders\RequestMiddleware;

use App\Models\PropertyListing;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use RoachPHP\Spider\Middleware\RequestMiddlewareInterface;
use RoachPHP\Support\Configurable;

class RightMoveRequestMiddleware implements RequestMiddlewareInterface
{
    use Configurable;

    public function handleRequest(Request $request, Response $response): Request
    {
        $path = explode('/', parse_url($request->getUri(), PHP_URL_PATH));
        $propertyId = $path[2];
        if(count(PropertyListing::where('right_move_id', $propertyId)->get()) > 0){
            return $request->drop('We already scraped this page!');
        }else{
            return $request;
        }
    }
}
