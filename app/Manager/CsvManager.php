<?php

namespace Tyorkin\HyperParserApplication\Manager;


use Tyorkin\HyperParserApplication\Storage\UrlFileStorage;
use Tyorkin\HyperParserApplication\Storage\UrlMongoStorage;

class CsvManager
{
    public function writeFromDbToFile(string $domainName): string
    {
        $urlMongoStorage = new UrlMongoStorage();
        $fileName = $domainName . '.csv';
        $urlFileStorage = new UrlFileStorage($fileName);
        $urlFileStorage->deleteAll();
        $urlList = $urlMongoStorage->findAll();
        foreach ($urlList as $urlEntity) {
            $urlFileStorage->insert($urlEntity);
        }

        $reflectionClass = new \ReflectionClass(UrlFileStorage::class);
        $reflectionProperty = $reflectionClass->getProperty('fileName');
        $reflectionProperty->setAccessible(true);
        $fileName = $reflectionProperty->getValue($urlFileStorage);

        return $fileName;

    }

}