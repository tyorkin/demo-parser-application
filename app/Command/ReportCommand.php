<?php

namespace Tyorkin\HyperParserApplication\Command;


use Tyorkin\HyperParserApplication\Exception\CommandParamException;
use Tyorkin\HyperParserApplication\Manager\ParserManager;
use Tyorkin\HyperParserApplication\Manager\UrlConsoleLogManager;
use Tyorkin\HyperParserApplication\Storage\UrlFileStorage;

class ReportCommand implements CommandInterface
{
    /**
     *
     */
    const NAME = 'report';

    /**
     * @param array $params
     */
    public function execute(array $params = [])
    {
        if (!isset($params[0])) {
            throw new CommandParamException();
        }

        $domain = $params[0];
        $logManager = new UrlConsoleLogManager();
        $logManager->log($domain);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "{$this->getName()} %domain% - Show report for domain.";
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }


}