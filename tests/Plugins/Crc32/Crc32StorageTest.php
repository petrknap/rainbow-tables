<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;
use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractStorage;
use PetrKnap\RainbowTables\Plugin\Crc32\Crc32Record;
use PetrKnap\RainbowTables\Plugin\Crc32\Crc32Storage;
use PetrKnap\Utils\DataStorage\Database;

class Crc32StorageTest extends AbstractStorageTest
{
    /**
     * @param Database $database
     * @param string $name
     * @return AbstractStorage
     */
    protected function createStorage($database, $name)
    {
        return new Crc32Storage($database, $name);
    }

    /**
     * @param array $data
     * @return AbstractRecord
     */
    protected function createRecord($data)
    {
        $record = new Crc32Record();

        $record->setData($data);

        return $record;
    }
}