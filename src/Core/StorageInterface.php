<?php

namespace PetrKnap\RainbowTables\Core;

interface StorageInterface
{
    /**
     * Prepares data storage
     *
     * @throws StorageException
     */
    public function createStorage();

    /**
     * Saves record into data storage
     *
     * @param RecordInterface|FindableInterface $record
     * @throws StorageException
     */
    public function saveRecord($record);

    /**
     * Saves records into data storage
     *
     * @param RecordInterface[]|FindableInterface[] $records
     * @return null|StorageException
     */
    public function saveRecords(array $records);

    /**
     * Returns record from data storage
     *
     * @param FindableInterface $record
     * @return RecordInterface
     * @throws StorageException
     */
    public function findRecord(FindableInterface $record);

    /**
     * Removes record from data storage
     *
     * @param FindableInterface $record
     * @throws StorageException
     */
    public function removeRecord(FindableInterface $record);
}
