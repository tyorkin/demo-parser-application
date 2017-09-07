<?php

namespace Tyorkin\HyperParserApplication\Command;


interface CommandInterface
{
    public function execute(array $params = []);
    public function getName();
    public function getDescription();
}