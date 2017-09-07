<?php

namespace Tyorkin\HyperParserApplication\Exception;

class UrlFileStorageException extends \RuntimeException
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null)
    {
        if (!$message) {
            $message = 'UrlFileStorage error';
        }
        parent::__construct($message, $code, $previous);
    }
}