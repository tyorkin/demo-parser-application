<?php

namespace Tyorkin\HyperParserApplication\Log;


interface ConsoleLogInterface extends LogInterface
{
    public function startWrite();
    public function endWrite();
}