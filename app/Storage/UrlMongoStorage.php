<?php

namespace Tyorkin\HyperParserApplication\Storage;

use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Exception\Exception as MongoException;
use MongoDB\Driver\Query;
use Tyorkin\HyperParserApplication\Document\Url;

class UrlMongoStorage extends MongoStorage
{

    const COLLECTION = 'url';

    /**
     * @var string
     */
    protected $namespace;

    public function __construct()
    {
        parent::__construct();
        $this->namespace = self::$database . '.' . self::COLLECTION;
    }

    public function findOne(array $filter = [])
    {

        try {
            $options = ['limit' => 1];
            $query = new Query($filter, $options);
            $cursor = self::$manager->executeQuery($this->namespace, $query);
            $cursor->setTypeMap(['root' => Url::class, 'array' => 'array']);
            $cursorArray = $cursor->toArray();
            if (!count($cursorArray)) {
                $result = null;
            } else {
                $result = current($cursorArray);
            }
        } catch (MongoException $e) {

            $result = null;
        }

        return $result;
    }

    public function findAll()
    {
        try {
            $query = new Query([]);
            $cursor = self::$manager->executeQuery($this->namespace, $query);
            $cursor->setTypeMap(['root' => Url::class/*, 'document' => 'Tyorkin\HyperParserApplication\Document\Url'*/, 'array' => 'array']);
            $result = $cursor->toArray();
        } catch (MongoException $e) {
            $result = null;
        }

        return $result;
    }

    public function insert($entity)
    {
        $result = true;
        try {
            $bulk = new BulkWrite();
            $bulk->insert($entity);
            $result = self::$manager->executeBulkWrite($this->namespace, $bulk);
        } catch (MongoException $e) {
            $result = false;
            echo $e->getMessage();
        }

        return $result;
    }

    public function update(array $filter, $entity)
    {
        $bulk = new BulkWrite();
        //$updateOptions = ['multi' => true];
        $bulk->update($filter, $entity);
        $updateResult = self::$manager->executeBulkWrite($this->namespace, $bulk);

        $result = $updateResult ? true : false;

        return $result;


    }

    public function delete(array $filter)
    {
        $bulk = new BulkWrite();
        $deleteOptions = ['limit' => 1];
        $bulk->delete($filter, $deleteOptions);
        self::$manager->executeBulkWrite($this->namespace, $bulk);
    }

    public function deleteAll()
    {
        $bulk = new BulkWrite();
        $bulk->delete([]);
        self::$manager->executeBulkWrite($this->namespace, $bulk);
    }


}