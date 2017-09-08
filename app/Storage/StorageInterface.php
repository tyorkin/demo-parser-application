<?php

namespace Tyorkin\HyperParserApplication\Storage;

interface StorageInterface extends SimpleStorageInterface
{
    /**
     * Return entity from the storage by filter
     * @param array $filter
     * @return array
     */
    public function findOne(array $filter = []);

    /**
     * Update entity from the storage by parameters
     * @param array $filter
     * @param $entity
     * @return void
     */
    public function update(array $filter, $entity);

    /**
     * Delete entity from the storage by $filter
     * @param array $filter
     * @return void
     */
    public function delete(array $filter);

}