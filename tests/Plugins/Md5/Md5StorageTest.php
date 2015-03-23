<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;
use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractStorage;
use PetrKnap\RainbowTables\Plugin\Md5\Md5Record;
use PetrKnap\RainbowTables\Plugin\Md5\Md5Storage;
use PetrKnap\Utils\DataStorage\Database;

class Md5StorageTest extends AbstractStorageTest
{
    /**
     * @param Database $database
     * @param string $name
     * @return AbstractStorage
     */
    protected function createStorage($database, $name)
    {
        return new Md5Storage($database, $name);
    }

    /**
     * @param array $data
     * @return AbstractRecord
     */
    protected function createRecord($data)
    {
        $record = new Md5Record();

        $record->setData($data);

        return $record;
    }
}