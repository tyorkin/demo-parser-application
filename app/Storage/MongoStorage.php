<?php

namespace Tyorkin\HyperParserApplication\Storage;

use Tyorkin\HyperParserApplication\Config\Config;
use MongoDB\Driver\Manager;

abstract class MongoStorage implements StorageInterface
{
    static protected $manager = null;
    static protected $database = null;

    public function __construct()
    {
        if (self::$manager != null) return;
        try {
            $dbConfig = Config::getMongoConfig();
            if ($dbConfig['dbUser'] && $dbConfig['dbPassword']) {
                self::$manager = new Manager('mongodb://' . $dbConfig['dbUser'] . ':' . $dbConfig['dbPassword'] . '@' . $dbConfig['dbHost'] . ':' . $dbConfig['dbPort'] . '/' . $dbConfig['dbName']);
            } else {
                self::$manager = new Manager('mongodb://' . $dbConfig['dbHost'] . ':' . $dbConfig['dbPort'] . '/' . $dbConfig['dbName']);
            }
            self::$database = $dbConfig['dbName'];
        } catch (\Exception $exc) {
            die($exc->getMessage());
        }

    }
}