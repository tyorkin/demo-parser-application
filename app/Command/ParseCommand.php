<?php

namespace Tyorkin\HyperParserApplication\Command;

use Tyorkin\HyperParserApplication\Exception\CommandParamException;
use Tyorkin\HyperParserApplication\Manager\CsvManager;
use Tyorkin\HyperParserApplication\Manager\ParserManager;
use Tyorkin\HyperParserApplication\Manager\SitemapManager;

class ParseCommand implements CommandInterface
{
    const NAME = "parse";

    public function execute(array $params = [])
    {
        if (!isset($params[0])) {
            throw new CommandParamException();
        }
        $url = $params[0];
        $parserManager = new ParserManager();
        $parserManager->parseSite($url);
        $sitemapManager = new SitemapManager();
        $sitemapManager->parseSitemap($url);
        $domain = $parserManager->getDomainFromUrl($url);
        $csvManager = new CsvManager();
        $fileName = $csvManager->writeFromDbToFile($domain);
        echo $fileName."\n";

    }

    public function getDescription()
    {
        return "{$this->getName()} %url% - Run parser with url start page.";
    }

    public function getName()
    {
        return self::NAME;
    }


}