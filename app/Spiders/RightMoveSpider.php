<?php

namespace App\Spiders;

use App\Spiders\ItemProcessors\RightMoveItemProcessor;
use App\Spiders\RequestMiddleware\RightMoveRequestMiddleware;
use Generator;

use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Illuminate\Support\Str;

class RightMoveSpider extends BasicSpider
{
    public array $startUrls = [
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E887810&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1609265&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E668521&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E307985&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E3956102&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E804376&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E4847646&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E868467&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1456025&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E765707&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E634516&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1658896&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E855468&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1343333&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E4205767&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1187485&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E660635&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E3843630&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E4510905&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E459920&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E746354&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1701895&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1605851&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1395665&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E228922&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1544320&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1063487&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1407072&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E928828&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E476927&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E481017&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1634085&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1323749&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1349199&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1058007&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E132700&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        RightMoveRequestMiddleware::class,
    ];

    public array $itemProcessors = [
        RightMoveItemProcessor::class
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $links = $response->filter('[data-test="property-header"]')->links();
        $finished = false;
        $props = [];
        $urls = [];
        $propertyIds = [];
        $duplicate = 0;
        if(count($links) < 1){
            $finished = true;
        }else{
            foreach($links as $link){
                $path = explode('/', parse_url($link->getUri(), PHP_URL_PATH));
                $propertyId = $path[2];
                if(array_search($propertyId, $propertyIds) || !is_numeric($propertyId)){
                    $duplicate++;
                    if( $duplicate > 1){
                        $finished = true;
                    }
                }else{
                    $propertyIds[] = $propertyId;
                    $urls[] = $link->getUri();
                    $prop = $response->filter("#property-" . $propertyId);
                    if($prop->filter("div.propertyCard-contacts a.propertyCard-branchLogo-link")->count() > 0){
                        $agent = $prop->filter("div.propertyCard-contacts a.propertyCard-branchLogo-link")->attr('title');
                    }else{
                        $agent = 'none';
                    }
                    $price = $prop->filter('.propertyCard-priceValue')->text();
                    $address = $prop->filter('.propertyCard-address')->text();
                    $props[] = [
                        'propertyId' => $propertyId,
                        'agent' => $agent,
                        'price' => $price,
                        'address' => $address,
                    ];
                    $request = new Request('GET', $link->getUri(), [$this, 'parsePropertyPage']);
                    $request = $request->withMeta('propertyId', $propertyId);
                    $request = $request->withMeta('agent', $agent);
                    $request = $request->withMeta('price', $price);
                    $request = $request->withMeta('address', $address);
                    yield ParseResult::fromValue($request);
                }
                if($finished){
                    break;
                }
            }
        }
        if(!$finished){
            $url = $response->getRequest()->getUri();
            $urlQueryString = parse_url($url, PHP_URL_QUERY);
            parse_str($urlQueryString, $queryString);
            if(array_key_exists('index', $queryString)){
                yield $this->request('GET', $this->startUrls[0] . '&index=' . $queryString['index'] + 24);
            }else{
                yield $this->request('GET', $this->startUrls[0] . '&index=24');
            }
        }
    }

    function parsePropertyPage(Response $response) : Generator {
        $text = $response->filter("article[data-testid='primary-layout']")->html();
        if(

            Str::of($text)->contains('short lease') ||
            Str::of($text)->contains('Short lease') ||
            Str::of($text)->contains('Short Lease') ||
            Str::of($text)->contains('SHORT LEASE')
        ){
            $search = 'Short Lease';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('japanese knotweed') ||
        //     Str::of($text)->contains('Japanese knotweed') ||
        //     Str::of($text)->contains('Japanese Knotweed') ||
        //     Str::of($text)->contains('JAPANESE KNOTWEED')
        // ){
        //     $search = 'Japanese Knotweed';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('non standard construction') ||
        //     Str::of($text)->contains('Non standard construction') ||
        //     Str::of($text)->contains('Non Standard construction') ||
        //     Str::of($text)->contains('Non Standard Construction') ||
        //     Str::of($text)->contains('NON STANDARD CONSTRUCTION')
        // ){
        //     $search = 'Non Standard Construction';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('UNMORTGAGEABLE') ||
        //     Str::of($text)->contains('Unmortgageable') ||
        //     Str::of($text)->contains('unmortgageable')
        // ){
        //     $search = 'Unmortgageable';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Structural Movement') ||
        //     Str::of($text)->contains('Structural movement') ||
        //     Str::of($text)->contains('structural movement') ||
        //     Str::of($text)->contains('STRUCTURAL MOVEMENT')
        // ){
        //     $search = 'Structural Movement';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('creeping freehold') ||
        //     Str::of($text)->contains('Creeping freehold') ||
        //     Str::of($text)->contains('Creeping Freehold') ||
        //     Str::of($text)->contains('CREEPING FREEHOLD')
        // ){
        //     $search = 'Creeping Freehold';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Subsidence') ||
        //     Str::of($text)->contains('subsidence') ||
        //     Str::of($text)->contains('SUBSIDENCE')
        // ){
        //     $search = 'Subsidence';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Wall Tie') ||
        //     Str::of($text)->contains('wall tie') ||
        //     Str::of($text)->contains('WALL TIE')
        // ){
        //     $search = 'Wall Tie';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Asbestos') ||
        //     Str::of($text)->contains('asbestos') ||
        //     Str::of($text)->contains('ASBESTOS')
        // ){
        //     $search = 'Asbestos';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Damp') ||
        //     Str::of($text)->contains('damp') ||
        //     Str::of($text)->contains('DAMP')
        // ){
        //     $search = 'Damp';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Dry Rot') ||
        //     Str::of($text)->contains('Dry rot') ||
        //     Str::of($text)->contains('dry rot') ||
        //     Str::of($text)->contains('DRY ROT')
        // ){
        //     $search = 'Dry Rot';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Wet Rot') ||
        //     Str::of($text)->contains('Wet rot') ||
        //     Str::of($text)->contains('wet rot') ||
        //     Str::of($text)->contains('WET ROT')
        // ){
        //     $search = 'Wet Rot';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Invasive Weeds') ||
        //     Str::of($text)->contains('Invasive weeds') ||
        //     Str::of($text)->contains('invasive weeds') ||
        //     Str::of($text)->contains('INVASIVE WEEDS')
        // ){
        //     $search = 'Invasive Weeds';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('Woodworm') ||
        //     Str::of($text)->contains('woodworm') ||
        //     Str::of($text)->contains('WOODWORM')
        // ){
        //     $search = 'Woodworm';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        // }elseif(
        //     Str::of($text)->contains('subject to structural') ||
        //     Str::of($text)->contains('Subject to structural') ||
        //     Str::of($text)->contains('SUBJECT TO STRUCTURAL')
        // ){
        //     $search = 'subject to structural';
        //     $relevant = true;

        //     yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('cash buyers') ||
            Str::of($text)->contains('Cash Buyers') ||
            Str::of($text)->contains('Cash buyers') ||
            Str::of($text)->contains('CASH BUYERS')
        ){
            $search = 'Cash Buyers';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('cash only') ||
            Str::of($text)->contains('Cash Only') ||
            Str::of($text)->contains('Cash only') ||
            Str::of($text)->contains('CASH ONLY')
        ){
            $search = 'Cash Only';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }else{
            $search = 'none';
            $relevant = false;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }
    }

    protected function compactListing(Response $response, $search, $relevant, $text) {
        $request = $response->getRequest();
        $propertyId = $request->getMeta('propertyId');
        $agent = $request->getMeta('agent');
        $price = $request->getMeta('price');
        $address = $request->getMeta('address');
        $uri = $response->getUri();
        return compact('propertyId', 'agent', 'price', 'address', 'uri', 'search', 'relevant', 'text');
    }
}
