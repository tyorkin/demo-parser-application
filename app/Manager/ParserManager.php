<?php

namespace Tyorkin\HyperParserApplication\Manager;

use Tyorkin\HyperParserApplication\Document\Url;
use Tyorkin\HyperParserApplication\Storage\UrlMongoStorage;
use Tyorkin\DemoParser\Provider\UrlProvider;
use Tyorkin\DemoParser\Provider\TagProvider;
use Tyorkin\DemoParser\Client\SimpleClient;
use Tyorkin\DemoParser\Exception\BadRequestException;

class ParserManager
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
     * @var TagProvider
     */
    private $tagProvider;

    /**
     * ParserManager constructor.
     */
    public function __construct()
    {
        $this->storage = new UrlMongoStorage();
        $this->client = new SimpleClient();
        $this->urlProvider = new UrlProvider();
        $this->tagProvider = new TagProvider();
    }

    /**
     * @param string $startUrl
     */
    public function parseSite(string $startUrl)
    {

        $url = $this->urlProvider->normalizeUrl($startUrl);
        $urlDocument = new Url();
        $urlDocument->setUrl($url);
        $this->storage->deleteAll();
        $this->storage->insert($urlDocument);
        $filter = ['isProcessed' => false];
        while ($urlDocument = $this->storage->findOne($filter)) {
            $this->processUrl($urlDocument);
        }
    }

    /**
     * @param Url $urlDocument
     */
    private function processUrl(Url $urlDocument)
    {
        $urlContent = '';
        try {
            $urlContent = $this->client->fetch($urlDocument->getUrl());
        } catch (BadRequestException $e) {
            if ($e->getCode() == BadRequestException:: CRITICAL_ERROR) {
                exit($e->getMessage());
            }
        }
        $urlContent = preg_replace("#<!--[^-]*(?:-(?!->)[^-]*)*-->#", "", $urlContent);
        $urlDocument->setTitleTagLength($this->tagProvider->getFirstTagTextLength('title', $urlContent));
        $urlDocument->setDescriptionTagLength($this->tagProvider->getFirstTagTextLength('description', $urlContent));
        $urlDocument->setH1TagLength($this->tagProvider->getFirstTagTextLength('h1', $urlContent));
        $urlDocument->setImgTagCount($this->tagProvider->getTagQuantity('img', $urlContent));
        $urlDocument->setATagCount($this->tagProvider->getTagQuantity('a', $urlContent));
        $urlDocument->setPTagsTextLength($this->tagProvider->getAllTagTextLength('p', $urlContent));
        $urlDocument->setPTagsTextLengthWithoutSpaces($this->tagProvider->getAllTagTextLengthWithoutSpaces('p', $urlContent));
        $urlDocument->setIsProcessed(true);
        $filter = ['url' => $urlDocument->getUrl()];
        $this->storage->update($filter, $urlDocument);
        $newUrlArray = $this->tagProvider->getAllTagAttributeValue('href', 'a', $urlContent);

        //$domain = $this->urlProvider->getDomainFromUrl($urlDocument->getUrl());
        $newDomainUrlArray = $this->urlProvider->findOnlyDomainLinks($urlDocument->getUrl(), $newUrlArray);
        foreach ($newDomainUrlArray as $newUrl) {
            $filter = ['url' => $newUrl];
            $existUrl = $this->storage->findOne($filter);
            if ($existUrl) {
                continue;
            }
            $newUrlDocument = new Url();
            $newUrlDocument->setUrl($newUrl);
            $this->storage->insert($newUrlDocument);
        }
    }

    /**
     * @param string $url
     * @return string
     */
    public function getDomainFromUrl(string $url): string
    {
        $domain = $this->urlProvider->getDomainFromUrl($url);

        return $domain;
    }
}