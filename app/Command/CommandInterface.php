<?php

namespace Tyorkin\HyperParserApplication\Command;

interface CommandInterface
{
    /**
     * @param array $params
     */
    public function execute(array $params = []);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;
}