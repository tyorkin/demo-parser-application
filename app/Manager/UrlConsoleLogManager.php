<?php

namespace Tyorkin\HyperParserApplication\Manager;

use Tyorkin\HyperParserApplication\Log\UrlConsoleLog;
use Tyorkin\HyperParserApplication\Storage\UrlFileStorage;

class UrlConsoleLogManager
{
    private $logger;
    public function __construct()
    {
        $this->logger = new UrlConsoleLog();
    }

    public function log($domain)
    {
        $parserManager = new ParserManager();
        $domainName = $parserManager->getDomainFromUrl($domain);
        $fileName = $domainName . '.csv';
        $urlFileStorage = new UrlFileStorage($fileName);
        $urlList = $urlFileStorage->findAll();
        if (!count($urlList)) {
            return;
        }
        $firstElement = $urlList[0]->bsonSerialize();
        $this->logger->startWrite();
        $header = array_keys($firstElement);
        $this->logger->write($header);
        $this->logger->startWrite();
        foreach ($urlList as $key => $url) {
            $urlArray = $url->bsonSerialize();
            $valuesArray = array_values($urlArray);
            $this->logger->write($valuesArray);
            if ($key && $key % 20 == 0) {
                $handle = fopen("php://stdin", "r");
                $line = fgets($handle);
                fclose($handle);
                echo "\r\033[K\033[1A\r\033[K\r";
            }
        }
        $this->logger->endWrite();
    }
}