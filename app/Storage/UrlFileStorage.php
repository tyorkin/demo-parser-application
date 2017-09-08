<?php

namespace Tyorkin\HyperParserApplication\Storage;

use Tyorkin\HyperParserApplication\Document\Url;
use Tyorkin\HyperParserApplication\Exception\UrlFileStorageException;

class UrlFileStorage extends FileStorage
{

    /**
     * @var null
     */
    private $header = null;

    /**
     * UrlFileStorage constructor.
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $fileName = $fileName . '.csv';
        parent::__construct($fileName);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $entityArray = [];
        if (!file_exists($this->fileName) || !($f = fopen($this->fileName, "r"))) {
            return $entityArray;
        }
        fgetcsv($f);
        while (($record = fgetcsv($f)) !== false) {
            $url = $this->arrayToUrlEntity($record);
            $entityArray[] = $url;
        }

        return $entityArray;
    }

    /**
     * @param $record
     * @return Url
     */
    private function arrayToUrlEntity($record)
    {
        $url = new Url();
        $header = $this->getFileHeader();
        $urlRecord = array_combine($header, $record);
        $url->bsonUnserialize($urlRecord);

        return $url;
    }

    /**
     * @return array|null
     */
    private function getFileHeader()
    {
        if ($this->header) {
            return $this->header;
        }
        $f = fopen($this->fileName, "r");
        if (!$f) {
            return null;
        }
        $header = fgetcsv($f);
        $this->header = $header;
        fclose($f);

        return $header;
    }

    /**
     * @param Url $entity
     */
    public function insert($entity)
    {
        $entityArray = $entity->bsonSerialize();
        clearstatcache(false, $this->fileName);
        if (!file_exists($this->fileName) || filesize($this->fileName) == 0) {
            $f = fopen($this->fileName, 'w');
            if (!$f) {
                throw new UrlFileStorageException('Error creating file');
            }
            fputcsv($f, array_keys($entityArray));
            fclose($f);
        }
        $f = fopen($this->fileName, "a");
        fputcsv($f, array_values($entityArray));
        fclose($f);
    }

    public function deleteAll()
    {
        $f = fopen($this->fileName, "w+");
        if ($f) {
            fclose($f);
        }
    }

}