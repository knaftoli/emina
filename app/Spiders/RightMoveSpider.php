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
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E751388&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',
        'https://www.rightmove.co.uk/property-for-sale/find.html?locationIdentifier=POSTCODE%5E480329&radius=40.0&includeSSTC=false&maxDaysSinceAdded=1',

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
            Str::of($text)->contains('cash buyers') ||
            Str::of($text)->contains('Cash Buyers') ||
            Str::of($text)->contains('Cash buyers') ||
            Str::of($text)->contains('CASH BUYERS')
        ){
            $search = 'Cash Buyers';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant));
        }elseif(
            Str::of($text)->contains('short lease') ||
            Str::of($text)->contains('Short lease') ||
            Str::of($text)->contains('Short Lease') ||
            Str::of($text)->contains('SHORT LEASE')
        ){
            $search = 'Short Lease';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant));
        }elseif(
            Str::of($text)->contains('japanese knotweed') ||
            Str::of($text)->contains('Japanese knotweed') ||
            Str::of($text)->contains('Japanese Knotweed') ||
            Str::of($text)->contains('JAPANESE KNOTWEED')
        ){
            $search = 'Japanese Knotweed';
            $relevant = true;

            yield $this->item($this->compactListing($response, $search, $relevant));
        }else{
            $search = 'none';
            $relevant = false;

            yield $this->item($this->compactListing($response, $search, $relevant));
        }
    }

    protected function compactListing(Response $response, $search, $relevant) {
        if ($relevant){
            $request = $response->getRequest();
            $propertyId = $request->getMeta('propertyId');
            $agent = $request->getMeta('agent');
            $price = $request->getMeta('price');
            $address = $request->getMeta('address');
            $uri = $response->getUri();
            return compact('propertyId', 'agent', 'price', 'address', 'uri', 'search', 'relevant');
        }else{
            $request = $response->getRequest();
            $propertyId = $request->getMeta('propertyId');
            $agent = 'none';
            $price = 'none';
            $address = 'none';
            $uri = 'none';
            return compact('propertyId', 'agent', 'price', 'address', 'uri', 'search', 'relevant');
        }
    }
}
