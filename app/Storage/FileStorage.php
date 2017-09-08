<?php

namespace Tyorkin\HyperParserApplication\Storage;


use Tyorkin\HyperParserApplication\Config\Config;

abstract class FileStorage implements SimpleStorageInterface
{
    /**
     * @var string
     */
    protected $fileName = '';

    /**
     * FileStorage constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = Config::getFileReportDir() . '/' . $fileName;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

}