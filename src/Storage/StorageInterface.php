<?php

namespace PetrKnap\RainbowTables\Storage;

use PetrKnap\RainbowTables\Record\FindableInterface;
use PetrKnap\RainbowTables\Record\RecordInterface;

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
     * @param RecordInterface $record
     * @throws StorageException
     */
    public function saveRecord(RecordInterface $record);

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
