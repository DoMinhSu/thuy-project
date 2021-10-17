<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Psr\Http\Message\UriInterface;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
class HandleCrawlObserver extends CrawlObserver
{
    public function finishedCrawling()
    {
        Log::alert("crawled");
    }
    public function willCrawl(UriInterface $url)
    {
        dd ($url);
    }
    public function shouldCrawl(UriInterface $url): bool{
        return true;
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ) {
        Log::alert("success");
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ) {
        Log::error($requestException);
    }

    // public function finishedCrawling(){
    //     Log::alert("finish");
    // }
}
