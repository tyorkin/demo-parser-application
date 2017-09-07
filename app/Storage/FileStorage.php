<?php

namespace Tyorkin\HyperParserApplication\Storage;


use Tyorkin\HyperParserApplication\Config\Config;

abstract class FileStorage implements SimpleStorageInterface
{
    protected $fileName = '';

    public function __construct($fileName)
    {
        $this->fileName = Config::getFileReportDir().'/'. $fileName;
    }

}