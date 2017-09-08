<?php

namespace Tyorkin\HyperParserApplication\Storage;

interface SimpleStorageInterface
{
    /**
     * Return entities from the storage
     * @return array
     */
    public function findAll();

    /**
     * Add entity to the storage
     * @param $entity
     * @return void
     */
    public function insert($entity);

    /**
     * Delete all entities from the storage
     * @return void
     */
    public function deleteAll();

}