<?php

namespace Tyorkin\HyperParserApplication\Exception;

class CommandParamException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null)
    {
        if (!$message) {
            $message = 'Wrong command parameter(s)';
        }
        parent::__construct($message, $code, $previous);
    }
}