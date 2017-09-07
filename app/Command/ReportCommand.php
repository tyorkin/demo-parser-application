<?php

namespace Tyorkin\HyperParserApplication\Command;


use Tyorkin\HyperParserApplication\Exception\CommandParamException;
use Tyorkin\HyperParserApplication\Manager\ParserManager;
use Tyorkin\HyperParserApplication\Manager\UrlConsoleLogManager;
use Tyorkin\HyperParserApplication\Storage\UrlFileStorage;

class ReportCommand implements CommandInterface
{
    const NAME = 'report';

    public function execute(array $params = [])
    {
        if (!isset($params[0])) {
            throw new CommandParamException();
        }

        $domain = $params[0];
        $logManager = new UrlConsoleLogManager();
        $logManager->log($domain);
    }

    public function getDescription()
    {
        return "{$this->getName()} %domain% - Show report for domain.";
    }

    public function getName()
    {
        return self::NAME;
    }


}