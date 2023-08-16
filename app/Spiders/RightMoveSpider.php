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
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1357219&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1493003&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E45694&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E302393&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E883464&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1692856&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E345212&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1344302&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E459905&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E480329&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E850178&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1055964&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E652598&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E608884&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1400870&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1635251&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E746788&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E4173320&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E160519&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E814297&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E1441391&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
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
            Str::of($text)->contains('japanese knotweed') ||
            Str::of($text)->contains('Japanese knotweed') ||
            Str::of($text)->contains('Japanese Knotweed') ||
            Str::of($text)->contains('JAPANESE KNOTWEED')
        ){
            $search = 'Japanese Knotweed';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('short lease') ||
            Str::of($text)->contains('Short lease') ||
            Str::of($text)->contains('Short Lease') ||
            Str::of($text)->contains('SHORT LEASE')
        ){
            $search = 'Short Lease';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('non standard construction') ||
            Str::of($text)->contains('Non standard construction') ||
            Str::of($text)->contains('Non Standard construction') ||
            Str::of($text)->contains('Non Standard Construction') ||
            Str::of($text)->contains('NON STANDARD CONSTRUCTION')
        ){
            $search = 'Non Standard Construction';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('UNMORTGAGEABLE') ||
            Str::of($text)->contains('Unmortgageable') ||
            Str::of($text)->contains('unmortgageable')
        ){
            $search = 'Unmortgageable';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('flying freehold') ||
            Str::of($text)->contains('Flying freehold') ||
            Str::of($text)->contains('Flying Freehold') ||
            Str::of($text)->contains('FLYING FREEHOLD')
        ){
            $search = 'Flying Freehold';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('Subsidence') ||
            Str::of($text)->contains('subsidence') ||
            Str::of($text)->contains('SUBSIDENCE')
        ){
            $search = 'Subsidence';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('Wall Tie') ||
            Str::of($text)->contains('wall tie') ||
            Str::of($text)->contains('WALL TIE')
        ){
            $search = 'Wall Tie';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('Asbestos') ||
            Str::of($text)->contains('asbestos') ||
            Str::of($text)->contains('ASBESTOS')
        ){
            $search = 'Asbestos';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('Damp') ||
            Str::of($text)->contains('damp') ||
            Str::of($text)->contains('DAMP')
        ){
            $search = 'Damp';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('Dry Rot') ||
            Str::of($text)->contains('Dry rot') ||
            Str::of($text)->contains('dry rot') ||
            Str::of($text)->contains('DRY ROT')
        ){
            $search = 'Dry Rot';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('subject to structural') ||
            Str::of($text)->contains('Subject to structural') ||
            Str::of($text)->contains('SUBJECT TO STRUCTURAL')
        ){
            $search = 'subject to structural';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('quick sale') ||
            Str::of($text)->contains('Quick sale') ||
            Str::of($text)->contains('Quick Sale') ||
            Str::of($text)->contains('QUICK SALE')
        ){
            $search = 'Quick Sale';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant, $text));
        }elseif(
            Str::of($text)->contains('cash buyers') ||
            Str::of($text)->contains('Cash Buyers') ||
            Str::of($text)->contains('Cash buyers') ||
            Str::of($text)->contains('CASH BUYERS')
        ){
            $search = 'Cash Buyers';
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
