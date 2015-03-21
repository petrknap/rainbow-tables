<?php

use PetrKnap\RainbowTables\Plugin\AbstractPlugin\AbstractRecord;
use PetrKnap\RainbowTables\Plugin\Crc32\Crc32Record;

class Crc32RecordTest extends AbstractRecordTest
{
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

    protected function calculateKey($inputData)
    {
        return crc32($inputData);
    }

    protected function calculateOutputData($inputData)
    {
        return crc32($inputData);
    }
}