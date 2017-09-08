<?php

namespace Tyorkin\HyperParserApplication\Manager;

use Tyorkin\HyperParserApplication\Document\Url;
use Tyorkin\DemoParser\Provider\UrlProvider;
use Tyorkin\DemoParser\Provider\SitemapProvider;
use Tyorkin\DemoParser\Client\SimpleClient;
use Tyorkin\HyperParserApplication\Storage\UrlMongoStorage;
use Tyorkin\DemoParser\Exception\BadRequestException;

class SitemapManager
{

    /**
     * @var UrlMongoStorage
     */
    private $storage;
    /**
     * @var SimpleClient
     */
    private $client;
    /**
     * @var UrlProvider
     */
    private $urlProvider;
    /**
     * @var SitemapProvider
     */
    private $sitemapProvider;

    /**
     * SitemapManager constructor.
     */
    public function __construct()
    {

        $this->storage = new UrlMongoStorage();
        $this->client = new SimpleClient();
        $this->urlProvider = new UrlProvider();
        $this->sitemapProvider = new SitemapProvider();

    }

    /**
     * @param $siteUrl
     */
    public function parseSitemap($siteUrl)
    {
        $domainName = $this->urlProvider->getDomainFromUrl($siteUrl);
        $siteUrl = $this->urlProvider->normalizeUrl($domainName);
        $robotsUrl = $siteUrl . '/robots.txt';
        $sitemapUrlList = [];
        try {
            $robotsContent = $this->client->fetch($robotsUrl);
            $sitemapUrlList = $this->sitemapProvider->getSitemapUrlListFromRobots($robotsContent);
        } catch (BadRequestException $e) {
            if ($e->getCode() == BadRequestException:: CRITICAL_ERROR) {
                exit($e->getMessage());
            }
        }
        if (!count($sitemapUrlList)) {
            $sitemapUrlList[] = $siteUrl . '/sitemap.xml';
        }

        $urlListFromSitemap = [];
        foreach ($sitemapUrlList as $siteMapUrl) {
            $sitemapContent = '';
            try {
                $sitemapContent = $this->client->fetch($siteMapUrl);
            } catch (BadRequestException $e) {
                if ($e->getCode() == BadRequestException:: CRITICAL_ERROR) {
                    exit($e->getMessage());
                }
            }
            if (!$sitemapContent) {
                continue;
            }
            $sitemapUrlList = $this->sitemapProvider->getUrlListFromSitemap($sitemapContent);
            $urlListFromSitemap = array_merge($urlListFromSitemap, $sitemapUrlList);
        }


        foreach ($urlListFromSitemap as $url) {
            $filter = ['url' => $url];
            /** @var Url $foundedUrl */
            $foundedUrl = $this->storage->findOne($filter);
            if ($foundedUrl) {
                $foundedUrl->setIsFoundInSitemap(true);
                $this->storage->update($filter, $foundedUrl);
            }
        }

    }
}