<?php

namespace Tyorkin\HyperParserApplication\Storage;

use MongoDB\Driver\Manager;
use Tyorkin\HyperParserApplication\Config\Config;

abstract class MongoStorage implements StorageInterface
{
    /**
     * @var Manager|null
     */
    static protected $manager = null;
    /**
     * @var string|null
     */
    static protected $database = null;

    public function __construct()
    {
        if (self::$manager != null) {
            return;
        }
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